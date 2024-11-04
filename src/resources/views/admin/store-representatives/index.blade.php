<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>Store Representatives</title>
</head>

<body>
  <h1>店舗代表者</h1>
  <a href="{{ route('admin.store-representatives.create') }}">新しい店舗代表者を作成</a>
  <h2>既存の店舗代表者</h2>
  <ul>
    @foreach($representatives as $representative)
    <li>{{ $representative->name }} - {{ $representative->email }}</li>
    @endforeach
  </ul>
</body>


</html>