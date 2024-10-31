<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者ログイン</title>
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>

<body>
  <div class="login-container">
    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif

    <h2>管理者ログイン</h2>
    @if($errors->any())
    <div class="error">{{ $errors->first('email') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login') }}">
      @csrf
      <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">ログイン</button>
    </form>
  </div>
</body>

</html>