<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ユーザー登録</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
  <header>
    <div class="menu-button">
      <button id="btn_menu8" class="btn_menu"><span></span></button>
    </div>
    <div class="rese">
      <a>Rese</a>
    </div>
  </header>

  <div id="nav-menu" class="nav-menu">
    <a href="/">Home</a>
    <a href="{{ route('register') }}">Registration</a>
    <a href="{{ route('login') }}">Login</a>
  </div>
  <div id="nav-overlay" class="nav-overlay"></div>

  <div class="login-form">
    <h2>Registration</h2>
    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="input-group">
        <i class="fa-solid fa-user"></i>
        <input type="text" name="name" placeholder="Username" value="{{ old('name') }}" required>
      </div>

      <div class="input-group">
        <i class="fa-solid fa-envelope"></i>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
      </div>

      <div class="input-group">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <!-- <div class="input-group">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
      </div> -->

      @error('name')
      <div class="error-message">{{ $message }}</div>
      @enderror

      @error('email')
      <div class="error-message">{{ $message }}</div>
      @enderror

      @error('password')
      <div class="error-message">{{ $message }}</div>
      @enderror

      <button type="submit" class="login-button">登録</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const navItems = document.querySelectorAll('.nav-menu a');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
      });

      navItems.forEach((item) => {
        item.addEventListener('click', function() {
          navMenu.classList.remove('active');
          navOverlay.classList.remove('active');
          document.body.classList.remove('no-scroll');
        });
      });
    });
  </script>
</body>

</html>