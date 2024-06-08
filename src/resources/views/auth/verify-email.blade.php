<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Verify Email Address</title>
</head>

<body>
  <h1>Verify Your Email Address</h1>
  <p>We have sent a verification link to your email address. Please click the link to verify your email.</p>
  @if (session('resent'))
  <div>
    <p>A fresh verification link has been sent to your email address.</p>
  </div>
  @endif
  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button type="submit">Resend Verification Email</button>
  </form>
</body>

</html>