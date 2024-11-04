<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>店舗ダッシュボード</title>
  <style>
    .section {
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
  </style>
</head>

<body>
  <h1>店舗ダッシュボード</h1>

  <div class="section">
    <h2>店舗情報</h2>
    <form action="{{ route('stores.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div>
        <label for="name">店舗名</label>
        <input type="text" name="name" id="name" value="{{ $shop->name }}" required>
      </div>
      <div>
        <label for="about">店舗情報</label>
        <textarea name="about" id="about" required>{{ $shop->about }}</textarea>
      </div>
      <div>
        <label for="photo">店舗写真</label>
        <input type="file" name="photo" id="photo">
      </div>
      <button type="submit">更新する</button>
    </form>
  </div>

  <div class="section">
    <h2>予約情報</h2>
    <table>
      <thead>
        <tr>
          <th>予約者名</th>
          <th>日時</th>
          <th>人数</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reservations as $reservation)
        <tr>
          <td>{{ $reservation->user->name }}</td>
          <td>{{ $reservation->date }} {{ $reservation->time }}</td>
          <td>{{ $reservation->people }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>

</html>