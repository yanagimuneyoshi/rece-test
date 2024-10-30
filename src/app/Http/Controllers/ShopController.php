<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
  // public function shop_all(Request $request)
  // {
  //   $areas = Area::all();
  //   $genres = Genre::all();
  //   $shops = Shop::query();

  //   if ($request->filled('area_id')) {
  //     $shops->where('area_id', $request->area_id);
  //   }

  //   if ($request->filled('genre_id')) {
  //     $shops->where('genre_id', $request->genre_id);
  //   }

  //   if ($request->filled('search')) {
  //     $shops->where('name', 'like', '%' . $request->search . '%');
  //   }

  //   $shops = $shops->with(['area', 'genre'])->get();

  //   $isLoggedIn = Auth::check();

  //   return view('shop_all', compact('areas', 'genres', 'shops', 'isLoggedIn'));
  // }

  // public function shop_all(Request $request)
  // {
  //   $areas = Area::all();
  //   $genres = Genre::all();

  //   // 店舗のクエリを作成
  //   $shops = Shop::query()->with(['area', 'genre', 'reviews']);

  //   if ($request->filled('area_id')) {
  //     $shops->where('area_id',
  //       $request->area_id
  //     );
  //   }

  //   if ($request->filled('genre_id')) {
  //     $shops->where('genre_id', $request->genre_id);
  //   }

  //   if ($request->filled('search')) {
  //     $shops->where('name', 'like', '%' . $request->search . '%');
  //   }

  //   // 並び替えオプションに基づいてクエリを調整
  //   if ($request->filled('sort')) {
  //     switch ($request->sort) {
  //       case 'high-rating':
  //         $shops->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
  //           ->selectRaw('shops.*, COALESCE(AVG(reviews.rating), 0) as average_rating')
  //           ->groupBy('shops.id')
  //           ->orderByDesc('average_rating');
  //         break;
  //       case 'low-rating':
  //         $shops->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
  //           ->selectRaw('shops.*, COALESCE(AVG(reviews.rating), 0) as average_rating')
  //           ->groupBy('shops.id')
  //           ->orderBy('average_rating');
  //         break;
  //       case 'random':
  //         $shops->inRandomOrder();
  //         break;
  //     }
  //   }

  //   $shops = $shops->get();
  //   $isLoggedIn = Auth::check();

  //   return view('shop_all', compact('areas', 'genres', 'shops', 'isLoggedIn'));
  // }

  public function shop_all(Request $request)
  {
    $areas = Area::all();
    $genres = Genre::all();

    // 検索クエリの構築
    $shops = Shop::query()->with(['area', 'genre', 'reviews']);

    if ($request->filled('area_id')) {
      $shops->where('area_id',
        $request->area_id
      );
    }

    if ($request->filled('genre_id')) {
      $shops->where('genre_id', $request->genre_id);
    }

    if ($request->filled('search')) {
      $shops->where('name', 'like', '%' . $request->search . '%');
    }

    // 並び替えの適用
    if ($request->filled('sort')) {
      switch ($request->sort) {
        case 'high-rating':
          $shops->leftJoin('reviews', 'shops.id',
            '=',
            'reviews.shop_id'
          )
          ->selectRaw('shops.*, COALESCE(AVG(reviews.rating), 0) as average_rating')
            ->groupBy('shops.id')
            ->orderByDesc('average_rating');
          break;
        case 'low-rating':
          $shops->leftJoin('reviews', 'shops.id',
            '=',
            'reviews.shop_id'
          )
            ->selectRaw('shops.*, COALESCE(AVG(reviews.rating), 0) as average_rating')
            ->groupBy('shops.id')
            ->orderBy('average_rating');
          break;
        case 'random':
          $shops->inRandomOrder();
          break;
      }
    }

    $shops = $shops->get();
    $isLoggedIn = Auth::check();

    return view('shop_all', compact('areas', 'genres', 'shops', 'isLoggedIn'));
  }



  public function shop_detail($shop_id)
  {
    $shop = Shop::with('area', 'genre')->findOrFail($shop_id);
    return view('shop_detail', compact('shop'));
  }

  public function show($id)
  {
    $shop = Shop::with('reviews.user')->findOrFail($id); // reviewsとそれに関連するuserを一緒に取得
    return view('shop_detail', compact('shop'));
  }
}
