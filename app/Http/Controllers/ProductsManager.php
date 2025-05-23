<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use DB;
use Illuminate\Http\Request;

class ProductsManager extends Controller
{
    function index()
    {
        $products = Products::paginate(8);
        return view('products', compact('products'));
    }
    function details($slug)
    {
        $product = Products::where('slug', $slug)->first();
        return view('details', compact('product'));
    }
    function addToCart($id)
    {
        $cart = new Cart();
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $id;
        if ($cart->save()) {
            return redirect()->back()->with('success', 'Product added to cart');
        } else {
            return redirect()->back()->with('error', 'Product not added to cart');
        }
    }
    public function showCart()
    {
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->select(
                'cart.product_id',
                DB::raw("MIN(cart.id) as cart_id"),
                DB::raw('count(*) as quantity'),
                'products.title',
                'products.price',
                'products.image',
                'products.slug'
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy('cart.product_id', 'products.title', 'products.price', 'products.image', 'products.slug')
            ->paginate(5);

        return view('cart', compact('cartItems'));

    }
    public function deleteCartItem($id)
    {
        Cart::where('user_id', auth()->user()->id)->where('id',$id)->delete();
        return redirect()->back()->with('success', 'Product removed from cart');
    }

}
