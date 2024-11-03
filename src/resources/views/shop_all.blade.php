<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Document</title>
  <link rel="stylesheet" href="css/shop_all.css" />
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div id="app">
    <div class="header-content">
      <div class="menu-button">
        <button id="btn_menu8" class="btn_menu" href="#"><span></span></button>
      </div>
      <div class="rese">
        <a>Rese</a>
      </div>

      <div id="nav-overlay" class="nav-overlay"></div>

      <nav id="nav-menu" class="header__nav">
        <a href="/"><span class="square_btn"></span></a>
        <a href="/" class="home">Home</a>


        @if ($isLoggedIn)
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

      <form class="search-form" action="{{ route('search') }}" method="GET">
        <div class="sort-dropdown">
          <label for="sort-select" class="sort-label">並び替え：</label>
          <select id="sort-select" class="sort-select" name="sort">
            <option value="random" {{ request('sort') == 'random' ? 'selected' : '' }}>ランダム</option>
            <option value="high-rating" {{ request('sort') == 'high-rating' ? 'selected' : '' }}>評価が高い順</option>
            <option value="low-rating" {{ request('sort') == 'low-rating' ? 'selected' : '' }}>評価が低い順</option>
          </select>
        </div>
        <div class="area">
          <select name="area_id">
            <option value="" selected="selected">All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="genre">
          <select name="genre_id">
            <option value="" selected="selected">All genre</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="research">
          <i class="fas fa-search check"></i>
          <input type="text" name="search" placeholder="Search…" value="{{ request('search') }}">
        </div>
      </form>

    </div>
  </div>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach ($shops ?? '' as $shop)
        <div class="col">
          <div class="card shadow-sm">
            <img src="{{ $shop->photo }}" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="{{ $shop->name }}">
            <div class="card-body">
              <div class="details">
                <p class="shop_name">{{ $shop->name }}</p>
              </div>
              <div class="details-row">
                <div class="details_all">
                  <p class="area">#{{ $shop->area->name }}</p>
                </div>
                <div class="details_2">
                  <p class="genre">#{{ $shop->genre->name }}</p>
                </div>
              </div>
              <div class="details_3">
                <button class="btn btn-primary" onclick="window.location.href='/detail/{{ $shop->id }}'">詳しく見る</button>
              </div>
              @if ($isLoggedIn)
              <i class="{{ $shop->is_favorite ? 'fas' : 'far' }} fa-heart favorite-heart" data-shop-id="{{ $shop->id }}"></i>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  </div>
  <div data-v-56ac30e2="" class="flex"></div>
  </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const favoriteHearts = document.querySelectorAll('.favorite-heart');
      favoriteHearts.forEach((heart) => {
        heart.addEventListener('click', (event) => {
          const target = event.currentTarget;
          const shopId = target.dataset.shopId;
          const isFavorited = target.classList.contains('fas');

          fetch(`/favorite/toggle/${shopId}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({
                isFavorited: !isFavorited
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                target.classList.toggle('fas');
                target.classList.toggle('far');
                target.classList.toggle('text-danger');
              }
            });
        });
      });

      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');

      btnMenu.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navOverlay.classList.toggle('active');
      });

      navOverlay.addEventListener('click', function() {
        navMenu.classList.remove('active');
        navOverlay.classList.remove('active');
      });
    });


    document.getElementById('sort-select').addEventListener('change', function() {
      const sortOption = this.value;
      const form = document.querySelector('.search-form');
      const url = new URL(form.action, window.location.origin);
      const formData = new FormData(form);

      formData.forEach((value, key) => {
        url.searchParams.set(key, value);
      });

      url.searchParams.set('sort', sortOption);

      window.location.href = url.toString();

    });
  </script>
</body>

</html>