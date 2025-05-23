<nav class="navbar navbar-expand-lg navbar-light sticky-top custom-navbar">
  <div class="container-fluid">
    
    <!-- Brand with Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <img src="{{ asset('assets/img/logo.png') }}" alt="SnackVerse Logo" style="height: 40px; width: auto;">
      <span class="fw-bold text-white fs-4">SnackVerse</span>
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" 
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-3">
        @auth  
        <li class="nav-item">
          <a class="nav-link" href="{{ route('order.history') }}">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.show') }}">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link logout-link" href="{{ route('logout') }}">Logout</a>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<!-- Custom Styles -->
<style>
  /* Navbar Styling */
  .custom-navbar {
    background: linear-gradient(90deg, #22c55e, #16a34a);
    border-radius: 0 0 1.25rem 1.25rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    padding: 0.8rem 1rem;
  }

  .navbar-brand span {
    transition: color 0.3s ease;
  }

  .navbar-brand:hover span {
    color: #bbf7d0;
  }

  .nav-link {
    position: relative;
    font-weight: 500;
    font-size: 1rem;
    color: #f8fafc !important;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
  }

  .nav-link::after {
    content: "";
    position: absolute;
    width: 0%;
    height: 2px;
    bottom: 4px;
    left: 0;
    background-color: #bbf7d0;
    transition: width 0.3s ease;
  }

  .nav-link:hover {
    color: #bbf7d0 !important;
    transform: translateY(-2px);
  }

  .nav-link:hover::after {
    width: 100%;
  }

  .logout-link {
    color: #fee2e2 !important;
  }

  .logout-link:hover {
    color: #f87171 !important;
  }

  .navbar-toggler {
    border: none;
  }

  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%2316a34a' viewBox='0 0 30 30'%3e%3cpath d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }

  @media (max-width: 991px) {
    .nav-link {
      font-size: 1.1rem;
      padding: 0.8rem 1rem;
    }

    .custom-navbar {
      padding: 1rem;
    }
  }
</style>
