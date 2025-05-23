<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products; // Import the Products model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class OrderManager extends Controller
{
    public function showCheckout()
    {
        return view('checkout');
    }

    public function checkoutPost(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'pincode' => 'required',
        ]);

        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'cart.product_id',
                DB::raw('count(*) as quantity'),
                'products.price',
                'products.title',
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy('cart.product_id', 'products.price', 'products.title')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect(route('cart.show'))->with('error', 'No items in cart');
        }

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $cartItem->title,
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->pincode = $request->pincode;
        $order->phone = $request->phone;
        $order->product_id = json_encode($productIds);
        $order->total_price = $totalPrice;
        $order->quantity = json_encode($quantities);

        if ($order->save()) {
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();

            $stripe = new StripeClient(config('app.STRIPE_KEY'));

            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('order.history'),
                'cancel_url' => route('payment.error'),
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return redirect($checkoutSession->url);
        } else {
            return redirect()->back()->with('error', 'Failed to place order');
        }
    }

    public function paymentError()
    {
        return "error";
    }

    public function paymentSuccess($order_id)
    {
        return "success " . $order_id;
    }


    public function webhookStripe(Request $request)
    {
        $endpointSecret = config("app.STRIPE_WEBHOOK_SECRET");
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the checkout.session.completed event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Retrieve metadata from the session
            $orderId = $session->metadata->order_id ?? null;
            $paymentId = $session->payment_intent ?? null;

            if ($orderId && $paymentId) {
                // Find the order by ID
                $order = Orders::find($orderId);

                if ($order) {
                    // Update the order with payment details
                    $order->payment_id = $paymentId;
                    $order->status = 'completed';
                    $order->save();

                    return response()->json(['status' => 'success'], 200);
                } else {
                    return response()->json(['error' => 'Order not found'], 404);
                }
            } else {
                return response()->json(['error' => 'Invalid metadata'], 400);
            }
        }

        return response()->json(['status' => 'ignored'], 200);
    }
    public function OrderHistory()
    {
        $orders = Orders::where('user_id', auth()->user()->id)->orderBy('id','DESC')->paginate(5);

        $orders->getCollection()->transform(function ($order) {
            $productIds = json_decode($order->product_id, true);
            $quantities = json_decode($order->quantity, true);

            $products = Products::whereIn('id', $productIds)->get();

            $order->product_details = $products->map(function ($product) use ($quantities, $productIds) {
                $index = array_search($product->id, $productIds);
                return [
                    'name' => $product->title,
                    'quantity' => $quantities[$index] ?? 0,
                    'price' => $product->price,
                    'slug' => $product->slug,
                    'image' => $product->image,
                ];
            });

            return $order;
        });

        return view("history", compact("orders"));
    }
}
