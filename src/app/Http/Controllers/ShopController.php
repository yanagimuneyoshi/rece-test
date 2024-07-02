<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
  public function shop_all(Request $request)
  {
    $areas = Area::all();
    $genres = Genre::all();
    $shops = Shop::query();

    if ($request->filled('area_id')) {
      $shops->where('area_id', $request->area_id);
    }

    if ($request->filled('genre_id')) {
      $shops->where('genre_id', $request->genre_id);
    }

    if ($request->filled('search')) {
      $shops->where('name', 'like', '%' . $request->search . '%');
    }

    $shops = $shops->with(['area', 'genre'])->get();

    $isLoggedIn = Auth::check();

    return view('shop_all', compact('areas', 'genres', 'shops', 'isLoggedIn'));
  }

  public function shop_detail($shop_id)
  {
    $shop = Shop::with('area', 'genre')->findOrFail($shop_id);
    return view('shop_detail', compact('shop'));
  }
}
