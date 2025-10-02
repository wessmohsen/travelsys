<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Travel Admin</title>

  <!-- AdminLTE v4 CSS -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="login-page bg-body-tertiary">

<div class="login-box">
  <!-- Card -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>Travel</b>Admin</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
          <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
        @error('email') <p class="text-danger small">{{ $message }}</p> @enderror

        <!-- Password -->
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-text"><span class="fas fa-lock"></span></div>
        </div>
        @error('password') <p class="text-danger small">{{ $message }}</p> @enderror

        <!-- Remember me -->
        <div class="row mb-3">
          <div class="col-8">
            <div class="form-check">
              <input type="checkbox" name="remember" class="form-check-input" id="remember">
              <label class="form-check-label" for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <!-- Links -->
      <p class="mb-1">
        <a href="{{ route('password.request') }}">Forgot Password?</a>
      </p>
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register a new account</a>
      </p>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
</body>
</html>
