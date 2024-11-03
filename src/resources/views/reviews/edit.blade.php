<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>口コミ編集</title>
  <style>
    .star-rating {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
    }

    .star-rating input[type="radio"] {
      display: none;
    }

    .star-rating label {
      font-size: 2em;
      color: lightgray;
      cursor: pointer;
    }

    .star-rating input[type="radio"]:checked~label {
      color: gold;
    }
  </style>
</head>

<body>
  <h1>口コミ編集</h1>
  <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
      <label for="rating">評価:</label>
      <div class="star-rating">
        @for ($i = 5; $i >= 1; $i--)
        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'checked' : '' }}>
        <label for="star{{ $i }}">★</label>
        @endfor
      </div>
    </div>

    <div>
      <label for="comment">コメント:</label>
      <textarea name="comment" id="comment" maxlength="400">{{ old('comment', $review->comment) }}</textarea>
    </div>

    <div>
      <label for="image">画像:</label>
      <input type="file" name="image" id="image" accept="image/*">
      <p id="error-message" style="color: red;"></p>
      @if ($review->image_path)
      <p>現在の画像:</p>
      <img src="{{ asset('storage/' . $review->image_path) }}" alt="現在の口コミ画像" width="200">
      @endif
    </div>

    <button type="submit">更新する</button>
  </form>

  <script>
    document.getElementById('image').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const errorMessage = document.getElementById('error-message');
      errorMessage.textContent = '';

      if (file) {
        const validTypes = ['image/jpeg', 'image/png'];
        if (!validTypes.includes(file.type)) {
          errorMessage.textContent = '画像はJPEGまたはPNG形式のみアップロード可能です。';
          event.target.value = '';
        }
      }
    });
  </script>
</body>

</html>