@extends("layouts.default")

@section("title", "Ecom - Home")

@section("style")
<style>
    body {
        background-color: #f9fafb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .product-container {
        background: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
        text-align: center;
    }

    .product-image {
        border-radius: 0.75rem;
        object-fit: cover;
        margin-bottom: 1.5rem;
        max-width: 250px;
        width: 100%;
        height: auto;
    }

    .product-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 500;
        color: #16a34a;
        margin-bottom: 1rem;
    }

    .product-description {
        font-size: 1rem;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .btn-success {
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        font-size: 1rem;
        border-radius: 0.5rem;
    }

    .alert-success {
        margin-top: 1rem;
        border-radius: 0.5rem;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
    }
</style>
@endsection

@section("content")
<main class="container" style="max-width: 900px">
    <section class="product-container">
        <img src="{{ $product->image }}" class="product-image" alt="{{ $product->title }}">
        
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        <h1 class="product-title">{{ $product->title }}</h1>
        <p class="product-price">Rs.{{ number_format($product->price, 2) }}</p>
        <p class="product-description">{{ $product->description }}</p>
        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success">Add to cart</a>
    </section>
</main>
@endsection
