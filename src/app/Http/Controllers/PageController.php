<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Reserve;

class PageController extends Controller
{
  public function thanks()
  {
    return view('thanks');
  }

  public function done()
  {
    return view('done');
  }

  public function menu1()
  {
    return view('menu1');
  }

  public function menu2()
  {
    return view('menu2');
  }

  public function my_page()
  {
    $user = Auth::user();

    $favorites = Favorite::where('user_id', $user->id)->with('shop.area', 'shop.genre')->get();
    $reservations = Reserve::where('user_ID', $user->id)->with('shop')->get();

    return view('my_page', compact('reservations', 'favorites'));
  }
}
