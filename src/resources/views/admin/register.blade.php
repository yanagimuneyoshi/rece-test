<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者登録</title>
  <link rel="stylesheet" href="{{ asset('css/admin/register.css') }}">
</head>

<body>
  <div class="register-container">
    <h2>管理者登録</h2>
    @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.register') }}">
      @csrf
      <div class="form-group">
        <label for="name">名前</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
      </div>
      <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
      </div>
      <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">パスワード（確認）</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
      </div>
      <button type="submit">登録</button>
    </form>
  </div>
</body>

</html>