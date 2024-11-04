<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/done.css') }}">
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
  <nav id="nav_menu" class="nav-menu">
    <button class="close-button" id="btn_close">×</button>
    <ul class="nav-items">
      <li class="nav-items__item"><a href="/">ホーム</a></li>
      <li class="nav-items__item"><a href="/login">ログアウト</a></li>
      <li class="nav-items__item"><a href="/my_page">マイページ</a></li>
    </ul>
  </nav>
  <div id="nav_overlay" class="nav-overlay"></div>
  <div class="done">
    <div class="done-message">
      <div class="message">ご予約ありがとうございます</div>
      <a href="/" class="back-button">戻る</a>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav_menu');
      const navOverlay = document.getElementById('nav_overlay');
      const btnClose = document.getElementById('btn_close');
      const navItems = document.querySelectorAll('.nav-menu a');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
        document.body.classList.toggle('no-scroll');
      });

      btnClose.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
        document.body.classList.remove('no-scroll');
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