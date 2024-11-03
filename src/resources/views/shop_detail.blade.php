<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
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
    <a href="{{ url('detail/' . $shop->id) }}" class="square_btn"></a>
    <a href="/" class="home">Home</a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout">Logout</button>
    </form>
    <a href="/my_page" class="mypage">Mypage</a>
  </nav>

  <div class="container">
    <div class="left-section">
      <div class="top-bar">
        <button class="back-button" onclick="history.back()">＜</button>
        <p class="shop_name">{{ $shop['name'] }}</p>
      </div>
      <img src="{{ $shop->photo }}" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="{{ $shop->name }}">
      <div class="area-genre-container">
        <p class="area">#{{ $shop['area']->name }}</p>
        <p class="genre">#{{ $shop['genre']->name }}</p>
      </div>
      <div class="about">
        <p>{{ $shop->about }}</p>
      </div>
      <a href="/reviews/create?shop_id={{ $shop->id }}" class="review-link">口コミを投稿する</a>
      <div class="reviews-section">
        <h2>全ての口コミ情報</h2>
        @if($shop->reviews->isNotEmpty())
        @foreach ($shop->reviews as $review)
        <div class="review">
          @if(Auth::check() && (Auth::id() == $review->user_id || Auth::user()->is_admin))
          <div class="review-actions">
            @if(Auth::id() == $review->user_id)
            <a href="{{ route('reviews.edit', $review->id) }}" class="edit-review">口コミを編集</a>
            @endif
            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
              @csrf
              @method('DELETE')
              <button type="submit" onclick="return confirm('本当に削除しますか？')" class="delete-review">口コミを削除</button>
            </form>
          </div>
          @endif
          <strong>{{ $review->user->name }}</strong>
          <p class="star">評価: {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
          <p>{{ $review->comment }}</p>
          @if ($review->image_url)
          <img src="{{ asset('storage/' . $review->image_path) }}" alt="口コミ画像" class="review-image">
          @endif
        </div>
        @endforeach
        @else
        <p>まだ口コミがありません。</p>
        @endif
      </div>
    </div>
    <div class="right-section">
      <h2>予約</h2>
      <form id="reservationForm" action="{{ route('reserve.store') }}" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        <div class="form-group">
          <label for="date">日付</label>
          <input type="date" id="date" name="date" onchange="displaySelectedDate()" required>
        </div>
        <div class="form-group">
          <label for="time">時間</label>
          <input type="time" id="time" name="time" onchange="displaySelectedTime()" required>
        </div>
        <div class="form-group">
          <label for="guests">人数</label>
          <select id="guests" name="guests" onchange="displaySelectedGuests()" required>
            @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}">{{ $i }}</option>
              @endfor
          </select>
        </div>
        <div class="reservation-summary">
          <p class="shop_name">店舗名：{{ $shop['name'] }}</p>
          <p id="selectedDate">日付: 選択された日付</p>
          <p id="selectedTime">時間: 選択された時間</p>
          <p id="selectedGuests">人数: 選択された人数</p>
        </div>
        <div class="submit-all">
          <button type="submit">予約する</button>
        </div>
        <p id="error-message" style="color: red;"></p>
      </form>
    </div>
  </div>
  <script>
    function displaySelectedDate() {
      var selectedDate = document.getElementById("date").value;
      var dateParagraph = document.getElementById("selectedDate");
      dateParagraph.textContent = "日付: " + selectedDate;
    }

    function displaySelectedTime() {
      var selectedTime = document.getElementById("time").value;
      var timeParagraph = document.getElementById("selectedTime");
      timeParagraph.textContent = "時間: " + selectedTime;
    }

    function displaySelectedGuests() {
      var selectedGuests = document.getElementById("guests").value;
      var guestsParagraph = document.getElementById("selectedGuests");
      guestsParagraph.textContent = "人数: " + selectedGuests;
    }

    document.addEventListener('DOMContentLoaded', function() {
      displaySelectedGuests();

      const btnMenu = document.getElementById('btn_menu8');
      const navMenu = document.getElementById('nav-menu');
      const navOverlay = document.getElementById('nav-overlay');
      const navItems = document.querySelectorAll('.header__nav a');

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

      var dateInput = document.getElementById('date');
      var today = new Date().toISOString().split('T')[0];
      dateInput.setAttribute('min', today);

      var form = document.getElementById('reservationForm');
      form.addEventListener('submit', function(event) {
        var selectedDate = dateInput.value;
        var selectedTime = document.getElementById('time').value;


        var errorMessage = document.getElementById('error-message');
        errorMessage.textContent = "";

        var selectedDateTime = new Date(selectedDate + 'T' + selectedTime);
        var now = new Date();

        if (selectedDateTime < now) {
          event.preventDefault();
          errorMessage.textContent = "過去の日時を選択することはできません。";
        }
      });
    });
  </script>
</body>

</html>