<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
  public function toggleFavorite(Request $request, $shopId)
  {
    $user = Auth::user();
    $favorite = Favorite::where('shop_id', $shopId)->where('user_id', $user->id)->first();

    if ($favorite) {
      $favorite->delete();
    } else {
      Favorite::create(['shop_id' => $shopId, 'user_id' => $user->id]);
    }

    return response()->json(['status' => 'success']);
  }
}
