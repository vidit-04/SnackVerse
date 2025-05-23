@extends("layouts.default")

@section("title", "Ecom - Cart")

@section('content')
    <main class="container" style="max-width: 900px">
        <section>
            <div class="row">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @foreach ($cartItems as $cart)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-3 text-center">
                                    <img src="{{ $cart->image }}" class="img-fluid rounded-start p-2" alt="{{ $cart->title }}"
                                        style="max-height: 120px; object-fit: contain;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1">
                                            <a href="{{ route('products.details', $cart->slug) }}" class="text-decoration-none">
                                                {{ $cart->title }}
                                            </a>
                                        </h5>
                                        <p class="card-text mb-0">
                                            <strong>Price:</strong> Rs.{{ $cart->price }}
                                        </p>
                                        <p class="card-text mb-0">
                                            <strong>Quantity:</strong> {{ $cart->quantity }}
                                            <a href="{{ route('cart.delete',$cart->cart_id) }}">Delete</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                {{ $cartItems->links() }}
            </div>
            <div>
                <a class="btn btn-success" href="{{ route('checkout.show') }}">Checkout</a>
            </div>
        </section>
    </main>
@endsection