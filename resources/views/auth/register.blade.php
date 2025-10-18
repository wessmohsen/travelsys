@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card card-outline card-primary" style="width: 400px;">
                <img src="https://sambodivers.com/wp-content/uploads/2022/04/sambo-logo.png" alt="Sambo System Logo" class="mb-2" style="max-width: 150px; display: block; margin: 10px auto 0 auto;">

    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1"><b>Sambo</b>System</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new account</p>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-group mb-3">
          <input id="name" type="text" name="name" value="{{ old('name') }}"
                 class="form-control @error('name') is-invalid @enderror"
                 placeholder="Full Name" required autofocus>
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
          @error('name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <!-- Email -->
        <div class="input-group mb-3">
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="Email" required>
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
          @error('email')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
          <input id="password" type="password" name="password"
                 class="form-control @error('password') is-invalid @enderror"
                 placeholder="Password" required>
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
          @error('password')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-3">
          <input id="password-confirm" type="password" name="password_confirmation"
                 class="form-control" placeholder="Retype password" required>
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>

        <!-- Register Button -->
        <div class="row mb-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div>
      </form>

      <p class="mb-0 text-center">
        <a href="{{ route('login') }}" class="text-center">I already have an account</a>
      </p>
    </div>
  </div>
</div>
@endsection
