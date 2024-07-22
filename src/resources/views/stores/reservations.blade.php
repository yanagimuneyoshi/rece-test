@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Reservations</h1>
  <ul>
    @foreach($reservations as $reservation)
    <li>{{ $reservation->user->name }} - {{ $reservation->reservation_date }}</li>
    @endforeach
  </ul>
</div>
@endsection