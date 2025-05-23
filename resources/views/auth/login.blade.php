@extends("layouts.auth")

@section("style")
  <style>
    body {
    background: linear-gradient(135deg, #22c55e, #4ade80);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-card {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 3rem;
    width: 100%;
    max-width: 420px;
    animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
    }

    .logo {
    width: 80px;
    margin: 0 auto 1.5rem;
    display: block;
    }

    .form-title {
    text-align: center;
    font-weight: 700;
    color: #16a34a;
    margin-bottom: 0.5rem;
    }

    .form-subtitle {
    text-align: center;
    font-size: 0.95rem;
    color: #6b7280;
    margin-bottom: 2rem;
    }

    .form-control:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
    }

    .btn-custom {
    background-color: #22c55e;
    color: #fff;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    }

    .logo {
    width: 100px;
    height: auto;
    margin: 0 auto 1.5rem;
    display: block;
    }

    .btn-custom:hover {
    background-color: #16a34a;
    transform: translateY(-2px);
    }

    .form-footer {
    font-size: 0.875rem;
    color: #9ca3af;
    text-align: center;
    margin-top: 2rem;
    }

    .alert {
    font-size: 0.9rem;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    }
  </style>
@endsection

@section("content")
  <main class="auth-card">
    <form method="POST" action="{{ route('login.post') }}">
    @csrf

    <img class="logo" src="{{ asset('assets/img/logo.png') }}" alt="Logo">

    <h2 class="form-title">Please Sign In</h2>
    <p class="form-subtitle">Access your account</p>

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

    <div class="mb-3">
      <label for="floatingEmail" class="form-label">Email address</label>
      <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
      @error('email')
      <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="mb-3">
      <label for="floatingPassword" class="form-label">Password</label>
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      @error('password')
      <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-check text-start my-3">
      <input name="rememberme" class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
      Remember me
      </label>
    </div>

    <button class="btn btn-custom w-100 mb-3" type="submit">
      Sign In
    </button>

    <div class="text-center">
      <a href="{{ route('register') }}" class="text-decoration-none text-success fw-semibold">
      Create new account
      </a>
    </div>

    <p class="form-footer">&copy; 2017–{{ date('Y') }} Your Company</p>
    </form>
  </main>
@endsection