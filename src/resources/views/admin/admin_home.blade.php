<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者ダッシュボード</title>
  <link rel="stylesheet" href="{{ asset('css/admin/admin_home.css') }}">
</head>

<body>
  <div class="dashboard-container">
    <div class="header">
      <h1>管理者ダッシュボード</h1>
      <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-button">ログアウト</button>
      </form>
    </div>
    <p>ようこそ、管理者専用のダッシュボードです。</p>

    <table>
      <thead>
        <tr>
          <th>ユーザー名</th>
          <th>店舗名</th>
          <th>コメント</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reviews as $review)
        <tr>
          <td>{{ $review->user->name ?? '不明' }}</td>
          <td>{{ $review->shop->name ?? '不明' }}</td>
          <td>{{ $review->comment }}</td>
          <td>
            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('この口コミを削除してもよろしいですか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete-button">削除</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <h2>店舗情報一覧</h2>
    <table>
      <thead>
        <tr>
          <th>店舗名</th>
          <th>地域</th>
          <th>ジャンル</th>
          <th>店舗概要</th>
          <th>画像</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($shops as $shop)
        <tr>
          <td>{{ $shop->name }}</td>
          <td>{{ $shop->area->name ?? '不明' }}</td>
          <td>{{ $shop->genre->name ?? '不明' }}</td>
          <td>{{ Str::limit($shop->about, 400) }}</td>
          <td>
            @if ($shop->photo)
            <img src="{{ $shop->photo }}" class="bd-placeholder-img card-img-top" width="100%" alt="{{ $shop->name }}">
            @else
            画像なし
            @endif
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>

    <h2>追加店舗情報のCSVインポート</h2>
    <form action="{{ route('admin.shops.import') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="file" name="csv_file" accept=".csv" required>
      <button type="submit">インポート</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif



    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif
  </div>
</body>

</html>