<!DOCTYPE html>
<html>

<head>
  <title>Image Upload</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <h2>Image Upload</h2>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <strong>{{ $message }}</strong>
    </div>
    <img src="{{ asset('storage/images/' . Session::get('image')) }}" width="300" />
    @endif
    <form action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="image">Select Image:</label>
        <input type="file" class="form-control" name="image" id="image">
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>
</body>

</html>