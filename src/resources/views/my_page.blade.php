<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/my_page.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

  <nav id="nav-menu" class="nav-menu">
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="/login">Logout</a></li>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout">Logout</button>
      </form>
      <li><a href="/my_page">Mypage</a></li>
    </ul>
  </nav>
  <div id="nav-overlay" class="nav-overlay"></div>

  <div class="container mt-5 pt-5">
    <div class="user text-center mt-5">
      <p class="userName">{{ Auth::user()->name }} さん</p>
    </div>

    <div class="contain mt-5 d-flex">
      <div class="reserve card p-3 me-3">
        <p class="title">予約状況</p>
        @if($reservations->isEmpty())
        <p>予約がありません。</p>
        @else
        @foreach ($reservations as $reservation)
        <div class="reservation-item p-3 mb-3 shadow-sm">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <i class="fa-regular fa-clock"></i>
            <i class="fa-regular fa-circle-xmark text-danger delete-reservation" data-reservation-id="{{ $reservation->id }}"></i>
          </div>
          <p class="shop_name">店舗名: {{ $reservation->shop->name ?? json_decode($reservation->shop)->name }}</p>
          <p class="Date">日付: {{ $reservation->date }}</p>
          <p class="Time">時間: {{ $reservation->time }}</p>
          <p class="Number">人数: {{ $reservation->people }}人</p>
        </div>
        @endforeach
        @endif
      </div>

      <div class="likes card p-3 flex-grow-1">
        <p class="title">お気に入り店舗</p>
        @if($favorites->isEmpty())
        <p>お気に入り店舗がありません。</p>
        @else
        <div class="row">
          @foreach ($favorites as $favorite)
          @if($favorite->shop)
          <div class="col-md-6 mb-3 favorite-card" data-shop-id="{{ $favorite->shop->id }}">
            <div class="card shadow-sm">
              <img class="card-img-top" src="{{ asset($favorite->shop->photo) }}" alt="{{ $favorite->shop->name }}">
              <div class="card-body">
                <p class="shop_name">{{ $favorite->shop->name }}</p>
                <p class="area">#{{ $favorite->shop->area->name }}</p>
                <p class="genre">#{{ $favorite->shop->genre->name }}</p>
                <button class="btn btn-primary" onclick="window.location.href='/detail/{{ $favorite->shop->id }}'">詳しく見る</button>
                <i class="{{ $favorite->shop->is_favorite ? 'fas' : 'far' }} fa-heart favorite-heart text-danger float-end" data-shop-id="{{ $favorite->shop->id }}"></i>
              </div>
            </div>
          </div>
          @endif
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const favoriteHearts = document.querySelectorAll('.favorite-heart');
      const deleteButtons = document.querySelectorAll('.delete-reservation');
      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const navItems = document.querySelectorAll('.nav-menu a');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
          const reservationId = button.dataset.reservationId;
          const confirmation = confirm("本当に削除しますか？");

          if (confirmation) {
            fetch(`/delete-reservation/${reservationId}`, {
                method: 'DELETE',
                headers: {
                  'X-CSRF-TOKEN': csrfToken,
                }
              })
              .then(response => {
                if (response.ok) {
                  button.closest('.reservation-item').remove();
                } else {
                  console.error('削除に失敗しました');
                }
              })
              .catch(error => {
                console.error('エラーが発生しました', error);
              });
          }
        });
      });

      favoriteHearts.forEach((heart) => {
        heart.addEventListener('click', (event) => {
          event.currentTarget.classList.toggle('fas');
          event.currentTarget.classList.toggle('far');
          event.currentTarget.classList.toggle('text-danger');

          const shopId = event.currentTarget.getAttribute('data-shop-id');
          fetch(`/favorite/toggle/${shopId}`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
              }
            }).then(response => response.json())
            .then(data => {
              if (data.status === 'success') {
                const card = document.querySelector(`.favorite-card[data-shop-id="${shopId}"]`);
                if (card) {
                  card.remove();
                }
              }
            });
        });
      });

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