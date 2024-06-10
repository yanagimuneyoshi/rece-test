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
    </div>

    <div id="nav-overlay" class="nav-overlay"></div>

    <nav id="nav-menu" class="header__nav">
      <ul class="nav-items">
        <li class="nav-items__item"><a href="/">Home</a></li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout">Logout</button>
        </form>
        <li class="nav-items__item"><a href="/login">Logout</a></li>
        <li class="nav-items__item"><a href="/my_page">Mypage</a></li>
      </ul>
    </nav>

    <form class="search-form" action="/search" method="post">
      @csrf
      <div data-v-56ac30e2="" class="search">
        <div data-v-56ac30e2="" class="area">
          <select data-v-56ac30e2="" name="area_id">
            <option data-v-56ac30e2="" value="" selected="selected">All area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
          </select>
        </div>
        <div data-v-56ac30e2="" class="genre">
          <select data-v-56ac30e2="" name="genre_id">
            <option data-v-56ac30e2="" value="" selected="selected">All genre</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
          </select>
        </div>
        <div data-v-56ac30e2="" class="research">
          <i data-v-56ac30e2="" class="fas fa-search check"></i>
          <input data-v-56ac30e2="" type="text" name="search" placeholder="Search…">
          <button type="submit" class="btn btn-primary" style="display:none;">検索</button>
        </div>
    </form>
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
                <p class="area">{{ $shop->area->name }}</p>
                <p class="genre">{{ $shop->genre->name }}</p>
                <button class="btn btn-primary" onclick="window.location.href='/detail/{{ $shop->id }}'">詳しく見る</button>
              </div>
              <i class="{{ $shop->is_favorite ? 'fas' : 'far' }} fa-heart favorite-heart" data-shop-id="{{ $shop->id }}"></i>
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