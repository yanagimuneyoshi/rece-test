<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>店舗代表者ログイン</title>
</head>

<body>
  <h1>店舗代表者ログイン</h1>
  <form action="{{ route('store_representative.login.submit') }}" method="POST">
    @csrf
    <div>
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required autofocus>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div>
      <label for="remember">
        <input type="checkbox" name="remember" id="remember"> Remember Me
      </label>
    </div>
    <button type="submit">ログイン</button>
  </form>
</body>

</html>