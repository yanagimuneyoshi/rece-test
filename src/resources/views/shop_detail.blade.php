<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}" />
</head>

<body>
  <header>
    <a href="/">
      <div class="menu-button">
        <button id="btn_menu8" class="btn_menu" href="#"><span>MENU</span></button>
      </div>
    </a>
    <div class="rese">
      <a>RESE</a>
    </div>
  </header>
  <div class="container">
    <div class="left-section">
      <h2>お店名</h2>
      <!-- <img src="path_to_image" alt="お店の写真"> -->
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

      <!-- <form action="{{ route('reserve.store') }}" method="POST">
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
      </form> -->
    </div>
  </div>
</body>
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
</script>

</html>