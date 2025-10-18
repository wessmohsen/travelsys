@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card card-outline card-primary" style="width: 400px;">
                <img src="https://sambodivers.com/wp-content/uploads/2022/04/sambo-logo.png" alt="Sambo System Logo" class="mb-2" style="max-width: 150px; display: block; margin: 10px auto 0 auto;">

    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1"><b>Sambo</b>System</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Forgot your password? Enter your email</p>

      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="input-group mb-3">
          <input id="email" type="email" name="email" value="{{ old('email') }}"
                 class="form-control @error('email') is-invalid @enderror"
                 placeholder="Email" required autofocus>
          <div class="input-group-text">
            <span class="fas fa-envelope"></span>
          </div>
          @error('email')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
          @enderror
        </div>

        <!-- Send Button -->
        <div class="row mb-3">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
          </div>
        </div>
      </form>

      <p class="mb-0 text-center">
        <a href="{{ route('login') }}">Back to Login</a>
      </p>
    </div>
  </div>
</div>
@endsection
