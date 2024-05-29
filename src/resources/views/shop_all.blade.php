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
    <div data-v-56ac30e2="" id="app">
      <div class="menu-button">
        <a href="/menu2"><button id="btn_menu8" class="btn_menu"><span>MENU</span></button></a>
      </div>
      <!-- <nav class="header__nav nav" id="js-nav">
        <ul class="nav__items nav-items">
          <li class="nav-items__item"><a href="/">HOME</a></li>
          <li class="nav-items__item"><a href="/register">Register</a></li>
          <li class="nav-items__item"><a href="/login">Login</a></li>
        </ul>
      </nav>
      <button class="header__hamburger hamburger" id="js-hamburger">
        <span></span>
        <span></span>
        <span></span>
      </button> -->
    </div>
      <div class="rese">
        <p>RESE</p>
      </div>
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
          <!-- <div data-v-56ac30e2="" class="research">
            <i data-v-56ac30e2="" class="fas fa-search check"></i>
            <input data-v-56ac30e2="" type="text" name="search" placeholder="Search…">
            <button type="submit" class="btn btn-primary">検索</button>
          </div> -->
      </form>
    </div>

    <!-- <div data-v-56ac30e2="" class="search">
        <form method="GET" action="{{ url('/shops') }}">
          <div data-v-56ac30e2="" class="area">
            <select data-v-56ac30e2="" name="area">
              <option data-v-56ac30e2="" value="" selected="selected">All area</option>
              <option data-v-56ac30e2="" value="東京都">東京都</option>
              <option data-v-56ac30e2="" value="大阪府">大阪府</option>
              <option data-v-56ac30e2="" value="福岡県">福岡県</option>
            </select>
          </div>
        </form>
        <div data-v-56ac30e2="" class="genre">
          <form method="GET" action="{{ url('/shops') }}">
            <select data-v-56ac30e2="" name="genre">
              <option data-v-56ac30e2="" value="" selected="selected">All genre</option>
              <option data-v-56ac30e2="" value="寿司">寿司</option>
              <option data-v-56ac30e2="" value="焼肉">焼肉</option>
              <option data-v-56ac30e2="" value="居酒屋">居酒屋</option>
              <option data-v-56ac30e2="" value="イタリアン">イタリアン</option>
              <option data-v-56ac30e2="" value="ラーメン">ラーメン</option>
            </select>
          </form>
        </div> -->
    <!-- <div data-v-56ac30e2="" class="research">
        <i data-v-56ac30e2="" class="fas fa-search check"></i>
        <input data-v-56ac30e2="" type="text" placeholder="Search…">
      </div> -->
  </div>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach ($shops ?? '' as $shop)
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
            </svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <p class="shop_name">{{ $shop['name'] }}</p>
                  <p class="area">#{{ $shop->area->name }}</p>
                  <p class="genre">#{{ $shop->genre->name }}</p>
                  <button class="btn btn-primary" onclick="window.location.href='/detail/{{ $shop->id }}'">詳しく見る</button>

                </div>

              </div>
              <i class="far fa-heart favorite-heart" data-shop-id="{{ $shop->id }}"></i>
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
      // ハンバーガーメニューの処理
      // const ham = document.querySelector('#js-hamburger');
      // const nav = document.querySelector('#js-nav');

      // ham.addEventListener('click', function() {
      //   ham.classList.toggle('active');
      //   nav.classList.toggle('active');
      // });


      // お気に入りハートの処理

      const favoriteHearts = document.querySelectorAll('.favorite-heart');
      favoriteHearts.forEach((heart) => {
        heart.addEventListener('click', (event) => {
          const target = event.currentTarget;
          const shopId = target.dataset.shopId; // データ属性からショップIDを取得
          const isFavorited = target.classList.contains('fas');

          fetch(`/favorite/toggle/${shopId}`, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRFトークンを設定
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
    });
  </script>
</body>

</html>