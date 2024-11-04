<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>お知らせメールの送信</title>
</head>

<body>
  <h1>お知らせメールの送信</h1>

  @if (session('status'))
  <p>{{ session('status') }}</p>
  @endif

  <form action="{{ route('admin.notifications.store') }}" method="POST">
    @csrf
    <div>
      <label for="user_id">送信先のユーザー</label>
      <select name="user_id" id="user_id" required>
        @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
      </select>
    </div>
    <div>
      <label for="subject">件名</label>
      <input type="text" name="subject" id="subject" required>
    </div>
    <div>
      <label for="message">メッセージ</label>
      <textarea name="message" id="message" rows="5" required></textarea>
    </div>
    <button type="submit">送信</button>
  </form>
</body>

</html>