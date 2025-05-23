@extends("layouts.default")

@section("title", "Ecom - Order History")

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

                @forelse ($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card shadow-lg border-0 rounded-3" style="max-width: 540px; transition: transform 0.3s ease;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $order->product_details[0]['image'] ?? asset('assets/img/default.png') }}" 
                                         class="img-fluid rounded-start" 
                                         alt="Product Image" style="object-fit: cover; height: 200px;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h5 class="card-title text-success mb-3">Order #{{ $order->id }}</h5>
                                        <p class="card-text text-muted">Payment ID: <span class="text-primary">{{ $order->payment_id ?? 'N/A' }}</span></p>
                                        <p class="card-text text-dark fw-bold">Total Price: <span class="text-warning">${{ $order->total_price }}</span></p>
                                        <h6 class="mt-3 text-dark">Products:</h6>
                                        <ul class="list-unstyled">
                                            @foreach ($order->product_details as $product)
                                                <li class="d-flex justify-content-between mb-3">
                                                    <a href="{{ route('products.details', $product['slug']) }}" class="text-decoration-none text-dark fw-semibold">
                                                        {{ $product['name'] }}
                                                    </a>
                                                    <span class="text-muted">Qty: {{ $product['quantity'] }} - ${{ $product['price'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No orders found.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <div class="pagination justify-content-center">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </main>
@endsection

@section('styles')
    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            background-color: #fafafa;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #007b5e;
            letter-spacing: 0.5px;
        }

        .text-muted {
            color: #6c757d;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-primary {
            color: #007bff;
        }

        .text-dark {
            color: #343a40;
        }

        .fw-semibold {
            font-weight: 600;
        }

        .pagination a {
            border-radius: 5px;
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #007b5e;
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        .pagination a:hover {
            background-color: #005f45;
        }

        .pagination .active {
            background-color: #005f45;
            color: white;
        }

        .pagination {
            display: flex;
            justify-content: center;
        }

        /* Hover effects for product details */
        .card-body a {
            transition: color 0.3s ease;
        }

        .card-body a:hover {
            color: #007b5e;
        }

        /* Gradient Background for overall container */
        body {
            background: linear-gradient(135deg, #f1f1f1, #e8f4f8);
        }

        /* Subtle shadow on hover */
        .list-unstyled li:hover {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
