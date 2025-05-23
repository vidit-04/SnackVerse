@extends("layouts.default")

@section("title", "Ecom - Home")

@section("style")
<style>
  body {
    background-color: #e9eff1;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
  }

  /* Hero Section */
  .hero-section {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    padding: 4rem 1rem;
    border-radius: 0 0 2rem 2rem;
    margin-bottom: 3rem;
    text-align: center;
    box-shadow: inset 0 -8px 20px rgba(0, 0, 0, 0.05);
  }

  .hero-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .hero-section p {
    font-size: 1.2rem;
    max-width: 700px;
    margin: 0 auto 2rem;
  }

  .hero-section .btn {
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 2rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  .hero-section img {
    max-width: 500px;
    width: 100%;
    margin-top: 2rem;
    animation: float 4s ease-in-out infinite;
  }

  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
  }

  /* Product Cards */
  .product-card {
    border: none;
    border-radius: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
    background: #ffffff;
    display: flex;
    flex-direction: column;
    height: 100%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
  }

  .product-img {
    width: 100%;
    height: 220px;
    object-fit: contain;
    padding: 1rem;
    background-color: #f9fafb;
    transition: transform 0.3s ease;
  }

  .product-img:hover {
    transform: scale(1.05);
  }

  .product-details {
    padding: 1rem;
    flex-grow: 1;
  }

  .product-title {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    color: #111827;
    text-decoration: none;
    display: block;
    transition: color 0.3s ease;
  }

  .product-title:hover {
    color: #22c55e;
  }

  .product-price {
    color: #16a34a;
    font-weight: 500;
    font-size: 0.95rem;
  }

  .pagination {
    justify-content: center;
    margin-top: 2rem;
  }

  .btn-success, .btn-primary {
    border-radius: 1rem;
    font-size: 0.95rem;
    padding: 0.75rem;
    transition: background 0.3s ease, transform 0.3s ease;
  }

  .btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
  }

  .btn-success {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    border: none;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #16a34a, #15803d);
    transform: translateY(-2px);
  }

  .action-buttons {
    gap: 0.5rem;
    padding: 0 1rem 1rem;
    position: relative;
    z-index: 1;
  }

  .card-body {
    padding: 1rem;
  }

  .card-footer {
    background-color: #f9fafb;
  }
</style>
@endsection

@section("content")
<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <h1>Welcome to SnackVerse</h1>
    <p>Your one-stop shop for tasty treats, healthy snacks, and all your food cravings — delivered fast & fresh!</p>
    <img src="{{ asset('assets/img/hero.png') }}" alt="Hero Snack Image"><br>
    <!-- Moved button below the image -->
    <a href="{{ route('cart.show') }}" class="btn btn-light text-success mt-4">Start Shopping</a>
  </div>
</section>

<!-- Product Section -->
<main class="container py-5" style="max-width: 1100px;">
  <section>
    <div class="row g-4">
      @foreach($products as $product)
        <div class="col-12 col-sm-6 col-lg-3 d-flex">
          <div class="card product-card shadow-sm w-100">
            <a href="{{ route('products.details', $product->slug) }}">
              <img src="{{ $product->image }}" alt="{{ $product->title }}" class="product-img">
            </a>
            <div class="product-details d-flex flex-column justify-content-between">
              <div>
                <a href="{{ route('products.details', $product->slug) }}" class="product-title">
                  {{ $product->title }}
                </a>
                <span class="product-price">Rs.{{ number_format($product->price, 2) }}</span>
              </div>
            </div>
            <div class="d-flex justify-content-between action-buttons">
              <a href="{{ route('products.details', $product->slug) }}" class="btn btn-primary w-50 text-center">
                View Item
              </a>
              <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success w-50 text-center">
                Add to Cart
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="d-flex pagination">
      {{ $products->links() }}
    </div>
  </section>
</main>
@endsection
