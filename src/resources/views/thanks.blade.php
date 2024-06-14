<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
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

  <div id="nav-overlay" class="nav-overlay"></div>

  <nav id="nav-menu" class="header__nav">
    <button class="close-button" id="btn_close">×</button>
    <ul class="nav-items">
      <li class="nav-items__item"><a href="/">Home</a></li>
      <li class="nav-items__item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-button">Logout</button>
        </form>
      </li>
      <li class="nav-items__item"><a href="/login">Login</a></li>
    </ul>
  </nav>

  <div class="content">
    <div class="done">
      <div class="thanks-message">
        <div class="message">会員登録ありがとうございます</div>
        <a href="login"><button class="back-button">ログインする</button></a>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const btnClose = document.getElementById('btn_close');
      const navItems = document.querySelectorAll('.nav-items__item a');

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