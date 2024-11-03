<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

  public function create(Request $request)
  {
    $shopId = $request->query('shop_id');
    $shop = Shop::findOrFail($shopId);


    $shop->is_favorite = Auth::check() && Auth::user()->favorites()->where('shop_id', $shop->id)->exists();

    return view('reviews', compact('shop'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'shop_id' => 'required|exists:shops,id',
      'rating' => 'required|integer|min:1|max:5',
      'comment' => 'nullable|string|max:400',
      'image' => 'nullable|image|mimes:jpeg,png|max:2048'
    ]);

    $shopId = $request->input('shop_id');
    $userId = Auth::id();


    $existingReview = Review::where('shop_id', $shopId)->where('user_id', $userId)->first();
    if ($existingReview) {
      return redirect()->back()->withErrors(['message' => 'この店舗には既に口コミを投稿しています。']);
    }


    $review = new Review([
      'shop_id' => $shopId,
      'user_id' => $userId,
      'rating' => $request->input('rating'),
      'comment' => $request->input('comment')
    ]);


    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('reviews', 'public');
      $review->image_path = $path;
    }

    $review->save();

    return redirect('/')->with('success', '口コミが投稿されました！');
  }

  public function edit($id)
  {

    $review = Review::findOrFail($id);

    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    return view('reviews.edit', compact('review'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'rating' => 'required|integer|min:1|max:5',
      'comment' => 'nullable|string|max:400',
      'image' => 'nullable|image|mimes:jpeg,png|max:2048'
    ]);

    $review = Review::findOrFail($id);

    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    $review->rating = $request->input('rating');
    $review->comment = $request->input('comment');

    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('reviews', 'public');
      $review->image_path = $path;
    }

    $review->save();

    return redirect()->route('shop.detail', ['shop_id' => $review->shop_id])
      ->with('success', '口コミが更新されました！');
  }


  public function destroy($id)
  {
    $review = Review::findOrFail($id);

    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    $review->delete();

    return redirect('/')->with('success', '口コミが削除されました！');
  }
}
