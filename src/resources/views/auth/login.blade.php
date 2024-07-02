<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <header>
    <div class="menu-button">
      <button id="btn_menu8" class="btn_menu" href="#"><span></span></button>
    </div>
    <div class="rese">
      <a href="/">Rese</a>
    </div>
    <div id="nav-overlay" class="nav-overlay"></div>

    <nav id="nav-menu" class="header__nav">
      <button id="btn_close" class="btn_close" href="#"><span>&times;</span></button>
      <ul class="nav-items">
        <li class="nav-items__item"><a href="/">Home</a></li>
        <li class="nav-items__item">
          <form>
            <a type="submit" href="/register">Registration</a>
          </form>
        </li>
        <li class="nav-items__item"><a href="/login">Login</a></li>
      </ul>
    </nav>
    <div id="nav-overlay" class="nav-overlay"></div>
  </header>

  <div class="login-form">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="input-group">
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="email" placeholder="Email" value="{{ old('email') }}">
        @if ($errors->has('email'))
        <div class="error-message">{{ $errors->first('email') }}</div>
        @endif
      </div>
      <div class="input-group">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Password">
        @if ($errors->has('password'))
        <div class="error-message">{{ $errors->first('password') }}</div>
        @endif
      </div>
      @if ($errors->has('login_error'))
      <div class="error-message">{{ $errors->first('login_error') }}</div>
      @endif
      <button type="submit" class="login-button">ログイン</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btnMenu = document.getElementById('btn_menu8');
      const btnClose = document.getElementById('btn_close');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
      });

      btnClose.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });

      const navItems = document.querySelectorAll('.nav-items__item a');
      navItems.forEach((item) => {
        item.addEventListener('click', function() {
          navMenu.classList.remove('active');
          navOverlay.classList.remove('active');
        });
      });
    });
  </script>

</body>

</html>