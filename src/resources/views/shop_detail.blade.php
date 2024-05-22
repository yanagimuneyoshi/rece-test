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
      <img src="path_to_image" alt="お店の写真">
      <p>エリア: エリア名</p>
      <p>ジャンル: ジャンル名</p>
      <div class="about">
        <h3>About</h3>
        <p>お店の説明文など</p>
      </div>
    </div>

    <div class="right-section">
      <h2>予約する</h2>
      <form action="/reservation" method="POST">
        @csrf
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
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
      </form>

      <div class="reservation-summary">
        <h2>予約内容</h2>
        <p>店舗名: ショップ名</p>
        <!-- <p>日付: 選択された日付</p> -->
        <p id="selectedDate">日付: 選択された日付</p>
        <!-- <p>時間: 選択された時間</p> -->
        <p id="selectedTime">時間: 選択された時間</p>
        <!-- <p>人数: 選択された人数</p> -->
        <p id="selectedGuests">人数: 選択された人数</p>
      </div>
      <div class="submit-all">
        <button type="submit">予約する</button>
      </div>
    </div>
  </div>
</body>
<script>
  function displaySelectedDate() {
    // Get the selected date value from the input
    var selectedDate = document.getElementById("date").value;


    // Get the paragraph element where the selected date will be displayed
    var dateParagraph = document.getElementById("selectedDate");

    // Update the text content of the paragraph to display the selected date
    dateParagraph.textContent = "日付: " + selectedDate;

  }

  function displaySelectedTime() {
    // Get the selected time value from the input
    var selectedTime = document.getElementById("time").value;

    // Get the paragraph element where the selected time will be displayed
    var timeParagraph = document.getElementById("selectedTime");

    // Update the text content of the paragraph to display the selected time
    timeParagraph.textContent = "時間: " + selectedTime;
  }

  function displaySelectedGuests() {
    // Get the selected guests value from the select element
    var selectedGuests = document.getElementById("guests").value;

    // Get the paragraph element where the selected guests will be displayed
    var guestsParagraph = document.getElementById("selectedGuests");

    // Update the text content of the paragraph to display the selected guests
    guestsParagraph.textContent = "人数: " + selectedGuests;
  }
</script>


</html>