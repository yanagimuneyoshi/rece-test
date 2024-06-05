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
    <nav id="nav-menu" class="header__nav">
      <ul class="nav-items">
        <li class="nav-items__item"><a href="/">Home</a></li>
        <li class="nav-items__item"><a href="/register">Registration</a></li>
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
        <input type="text" name="email" placeholder="Email">
      </div>
      <div class="input-group">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Password">
      </div>
      @if($errors->has('login_error'))
      <div class="error-message">{{ $errors->first('login_error') }}</div>
      @endif
      <button type="submit" class="login-button">ログイン</button>
    </form>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const navItems = document.querySelectorAll('.nav-items__item a');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });

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