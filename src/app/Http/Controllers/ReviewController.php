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

    // 新しいレビューインスタンスを作成
    $review = new Review([
      'shop_id' => $request->input('shop_id'),
      'user_id' => Auth::id(), // ログインユーザーのIDを設定
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
    return redirect('/')
      ->with('success', '口コミが投稿されました！');
  }

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

  // ReviewController.phpのupdateメソッド
  public function update(Request $request, $id)
  {
    // バリデーション
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

    // shop_idパラメータを渡す
    return redirect()->route('shop.detail', ['shop_id' => $review->shop_id])
      ->with('success', '口コミが更新されました！');
  }


  public function destroy($id)
  {
    $review = Review::findOrFail($id);

    // 認証ユーザーが自分の口コミ、または管理者のみ削除可能
    if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
      abort(403, 'Unauthorized action.');
    }

    $shopId = $review->shop_id; // shop_idを取得
    $review->delete();

    return redirect('/')
      ->with('success', '口コミが削除されました！');
  }


}
