<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>口コミを投稿</title>
  <link rel="stylesheet" href="{{ asset('css/review.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <header>
    <div class="header-content">
      <div class="menu-button">
        <button id="btn_menu8" class="btn_menu"><span></span></button>
      </div>
      <div class="rese">
        <a>Rese</a>
      </div>
    </div>
  </header>

  <div id="nav-overlay" class="nav-overlay"></div>
  <nav id="nav-menu" class="header__nav">
    <button id="close-menu" class="close-menu">×</button>
    <a href="/" class="home">Home</a>
    @if (Auth::check())
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout">Logout</button>
    </form>
    <a href="/my_page" class="mypage">Mypage</a>
    @else
    <a href="/login" class="login">Login</a>
    <a href="/register" class="register">Register</a>
    @endif
  </nav>

  <div class="main-container">
    <div class="shop-info">
      <h1>今回のご利用はいかがでしたか？</h1>
      <div class="card">
        <img src="{{ $shop->photo }}" alt="{{ $shop->name }}" class="shop-image">
        <div class="card-body">
          <h3 class="shop-name">{{ $shop->name }}</h3>
          <p class="area-genre">#{{ $shop->area->name }} #{{ $shop->genre->name }}</p>
          <p class="shop-description">{{ $shop->description }}</p>
          <i class="{{ $shop->is_favorite ? 'fas' : 'far' }} fa-heart favorite-heart text-danger float-end" data-shop-id="{{ $shop->id }}"></i>
        </div>
      </div>
    </div>


    <div class="vertical-divider"></div>


    <div class="review-form">
      <h2>体験を評価してください</h2>
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form action="{{ route('reviews.store', ['shop' => $shop->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

        <div class="rating">
          <label>体験を評価してください</label>
          <div class="stars">
            <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
            <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
            <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
            <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
            <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
          </div>
        </div>

        <div class="form-group">
          <label for="comment">口コミを投稿</label>
          <textarea id="comment" name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット" maxlength="400"></textarea>
          <span class="character-count">0/400</span>
        </div>

        <div class="form-group">
          <label for="image">画像の追加</label>
          <input type="file" id="image" name="image" accept="image/*" multiple>
          <p class="image-hint">クリックして写真を追加またはドラッグアンドドロップ</p>
        </div>

        <button type="submit" class="submit-btn">口コミを投稿</button>
      </form>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const favoriteHeart = document.querySelector('.favorite-heart');

      favoriteHeart.addEventListener('click', function() {
        favoriteHeart.classList.toggle('fas');
        favoriteHeart.classList.toggle('far');
        favoriteHeart.classList.toggle('text-danger');

        const shopId = favoriteHeart.getAttribute('data-shop-id');
        fetch(`/favorite/toggle/${shopId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json'
            }
          }).then(response => response.json())
          .then(data => {
            if (data.status !== 'success') {
              console.error('お気に入りの切り替えに失敗しました');
            }
          }).catch(error => {
            console.error('エラーが発生しました', error);
          });
      });

      // ハンバーガーメニューのトグル
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const closeMenu = document.getElementById('close-menu');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });

      closeMenu.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });

      document.getElementById('comment').addEventListener('input', function() {
        const count = this.value.length;
        document.querySelector('.character-count').textContent = `${count}/400`;
      });
    });
  </script>
</body>

</html>