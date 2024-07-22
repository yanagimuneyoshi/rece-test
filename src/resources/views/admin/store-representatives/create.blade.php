<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Create Store Representative</title>
</head>

<body>
  <h1>店舗担当者の作成</h1>
  <form action="{{ route('admin.store-representatives.store') }}" method="POST">
    @csrf
    <label for="shop_id">店舗を選択</label>
    <select name="shop_id" id="shop_id" required autocomplete="off">
      @foreach($shops as $shop)
      <option value="{{ $shop->id }}">{{ $shop->name }}</option>
      @endforeach
    </select>
    @if ($errors->has('shop_id'))
    <div>{{ $errors->first('shop_id') }}</div>
    @endif

    <input type="email" name="email" placeholder="Email" required autocomplete="email">
    @if ($errors->has('email'))
    <div>{{ $errors->first('email') }}</div>
    @endif

    <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
    @if ($errors->has('password'))
    <div>{{ $errors->first('password') }}</div>
    @endif

    <input type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
    @if ($errors->has('password_confirmation'))
    <div>{{ $errors->first('password_confirmation') }}</div>
    @endif

    <button type="submit">作成する</button>
  </form>
</body>

</html>