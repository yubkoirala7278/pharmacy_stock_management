@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-11 col-sm-8 col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 animate__animated animate__fadeIn" style="background: rgba(255, 255, 255, 0.95); border-radius: 20px; border: 2px solid transparent; border-image: linear-gradient(to right, #007bff, #00d4ff) 1;">
            <div class="card-body p-4 p-md-5">
                <h2 class="card-title text-center mb-4" style="color: #004c97; font-weight: 700; font-size: 1.8rem;">
                    <i class="bi bi-capsule me-2"></i>Pharmacy Login
                </h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <div class="form-floating">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                            <label for="email" class="form-label text-muted">Email Address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-floating">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <label for="password" class="form-label text-muted">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">
                            Remember Me
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" style="background: linear-gradient(to right, #007bff, #00d4ff); border: none; border-radius: 10px; transition: transform 0.3s, box-shadow 0.3s;">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons (for capsule icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css for fade-in animation -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<style>
    .form-control {
        border-radius: 10px;
        transition: box-shadow 0.3s, border-color 0.3s;
    }
    .form-control:focus {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.4);
        border-color: #007bff;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    @media (max-width: 576px) {
        .card-body {
            padding: 2rem !important;
        }
        .card-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection