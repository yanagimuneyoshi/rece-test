@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Store Information</h1>
  <form action="{{ route('stores.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="name">Store Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ $shop->name }}" required>
    </div>
    <div class="form-group">
      <label for="about">About</label>
      <textarea name="about" id="about" class="form-control" required>{{ $shop->about }}</textarea>
    </div>
    <div class="form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" id="photo" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
@endsection