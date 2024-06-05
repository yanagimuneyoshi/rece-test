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
  <nav id="nav-menu" class="nav-menu">
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="/login">Logout</a></li>
      <li><a href="/my_page">Mypage</a></li>
    </ul>
  </nav>

  <div class="container">
    <div class="left-section">
      <h2>お店名</h2>
      <img src="{{ $shop->photo }}" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="{{ $shop->name }}">
      <p class="shop_name">{{ $shop['name'] }}</p>
      <p>エリア: エリア名</p>
      <p class="area">#{{ $shop->area->name }}</p>
      <p>ジャンル: ジャンル名</p>
      <p class="genre">#{{ $shop->genre->name }}</p>
      <div class="about">
        <h3>About</h3>
        <p>お店の説明文など</p>
        <p>{{ $shop->about }}</p>
      </div>
    </div>

    <div class="right-section">
      <h2>予約する</h2>
      <form action="{{ route('reserve.store') }}" method="POST">
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
          <h2>予約内容</h2>
          <p>店舗名:</p>
          <p class="shop_name">{{ $shop['name'] }}</p>
          <p id="selectedDate">日付: 選択された日付</p>
          <p id="selectedTime">時間: 選択された時間</p>
          <p id="selectedGuests">人数: 選択された人数</p>
        </div>
        <div class="submit-all">
          <button type="submit">予約する</button>
        </div>
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
      const navItems = document.querySelectorAll('.nav-menu a');

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