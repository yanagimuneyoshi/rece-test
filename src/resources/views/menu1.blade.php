<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/menu1.css') }}" />
</head>

<header>
  <a href="/"><span class="square_btn"></span></a>
</header>

<body>
  <a href="/">
    <div class="home">Home</div>
  </a>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="logout">Logout</button>
  </form>
  <a href="/my_page">
    <div class="mypage">Mypage</div>
  </a>
</body>

</html>