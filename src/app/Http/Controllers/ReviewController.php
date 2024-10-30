<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
  // 口コミ投稿画面の表示
  public function create(Request $request)
  {
    $shopId = $request->query('shop_id');
    $shop = Shop::findOrFail($shopId);

    // お気に入り情報を追加
    $shop->is_favorite = Auth::check() && Auth::user()->favorites()->where('shop_id', $shop->id)->exists();

    return view('reviews', compact('shop'));
  }

  // 口コミの保存処理
  public function store(Request $request)
  {
    $request->validate([
      'shop_id' => 'required|exists:shops,id',
      'rating' => 'required|integer|min:1|max:5',
      'comment' => 'nullable|string|max:400',
      'image' => 'nullable|image|mimes:jpeg,png|max:2048' // 画像のバリデーション（JPEG, PNG、2MBまで）
    ]);

    $shopId = $request->input('shop_id');
    $userId = Auth::id();

    // すでに同じ店舗に口コミを投稿しているかチェック
    $existingReview = Review::where('shop_id', $shopId)->where('user_id', $userId)->first();
    if ($existingReview) {
      return redirect()->back()->withErrors(['message' => 'この店舗には既に口コミを投稿しています。']);
    }

    // 新しいレビューインスタンスを作成
    $review = new Review([
      'shop_id' => $shopId,
      'user_id' => $userId,
      'rating' => $request->input('rating'),
      'comment' => $request->input('comment')
    ]);

    // 画像のアップロード処理
    if ($request->hasFile('image')) {
      $path = $request->file('image')->store('reviews', 'public');
      $review->image_path = $path;
    }

    // レビューを保存
    $review->save();

    // データが保存されたらトップページにリダイレクト
    return redirect('/')->with('success', '口コミが投稿されました！');
  }

  // 口コミ編集画面の表示
  public function edit($id)
  {
    // 口コミの情報を取得
    $review = Review::findOrFail($id);

    // ユーザーが自分の口コミのみ編集できるようにする
    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    return view('reviews.edit', compact('review'));
  }

  // 口コミの更新処理
  public function update(Request $request, $id)
  {
    $request->validate([
      'rating' => 'required|integer|min:1|max:5',
      'comment' => 'nullable|string|max:400',
      'image' => 'nullable|image|mimes:jpeg,png|max:2048'
    ]);

    $review = Review::findOrFail($id);

    // 認証ユーザーのみ編集可能
    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    // 更新処理
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

  // 口コミの削除処理
  public function destroy($id)
  {
    $review = Review::findOrFail($id);

    // 認証ユーザーが自分の口コミ、または管理者のみ削除可能
    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    $review->delete();

    return redirect('/')->with('success', '口コミが削除されました！');
  }
}
