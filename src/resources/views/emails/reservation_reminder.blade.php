<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>予約リマインダー</title>
</head>

<body>
  <p>以下の予約を確認してください：</p>
  <p>店舗名: {{ $reservation->shop->name }}</p>
  <p>日付: {{ $reservation->date }}</p>
  <p>時間: {{ $reservation->time }}</p>
  <p>人数: {{ $reservation->guests }}</p>
</body>

</html>