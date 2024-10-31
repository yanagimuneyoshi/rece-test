<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;





class AdminController extends Controller
{
  public function dashboard()
  {

    $reviews = Review::with(['user', 'shop'])->get(); // ユーザーと店舗情報を含む
    $reviews = Review::with(['user', 'shop'])->get();
    $shops = Shop::with(['area', 'genre'])->get(); // エリアとジャンルの情報も取得
    return view('admin.admin_home', compact('reviews', 'shops'));
    // return view('admin.admin_home');
  }


  // public function deleteAllReviews()
  // {
  //   Review::truncate(); // 全ての口コミを削除
  //   return redirect()->route('admin.dashboard')->with('status', '全ての口コミが削除されました。');
  // }

  public function deleteReview($id)
  {
    $review = Review::findOrFail($id);
    $review->delete();

    return redirect()->route('admin.dashboard')->with('status', '口コミが削除されました。');
  }

  public function showReviews()
  {
    // 必要な情報を関連するテーブルから取得
    $reviews = Review::with(['user', 'shop'])->get(); // user, shop とのリレーションを通して取得
    return view('admin.reviews', compact('reviews'));
  }

  public function importShops(Request $request)
  {
    $request->validate([
      'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $data = array_map('str_getcsv', file($file->getRealPath()));

    // CSVファイルの1行目をヘッダーとして取得（カラム名）
    $headers = $data[0];
    unset($data[0]);

    // foreach ($data as $row) {
    //   $rowData = array_combine($headers, $row);

    //   // バリデーション
    //   $validator = Validator::make($rowData, [
    //     'name' => 'required|string|max:50',
    //     'region' => 'required|in:東京都,大阪府,福岡県',
    //     'genre' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
    //     'description' => 'required|string|max:400',
    //     'image_url' => 'nullable|url|regex:/\.(jpeg|jpg|png)$/i',
    //   ]);

    //   if ($validator->fails()) {
    //     return redirect()->back()->withErrors($validator)->withInput();
    //   }

    //   // 店舗情報の追加
    //   Shop::create([
    //     'name' => $rowData['name'],
    //     'area_id' => Area::where('name', $rowData['region'])->first()->id,
    //     'genre_id' => Genre::where('name', $rowData['genre'])->first()->id,
    //     'about' => $rowData['description'],
    //     'photo' => $rowData['photo'],
    //   ]);
    // }
    foreach ($data as $row) {
      $rowData = array_combine($headers, $row);

      // バリデーション
      $validator = Validator::make($rowData, [
        'name' => 'required|string|max:50',
        'area' => 'required|exists:areas,name', // areasテーブルに存在するかチェック
        'genre' => 'required|exists:genres,name', // genresテーブルに存在するかチェック
        'about' => 'required|string|max:400',
        'photo' => 'nullable|url|regex:/\.(jpeg|jpg|png)$/i',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      // 地域とジャンルを取得
      $area = Area::where('name', $rowData['area'])->first();
      $genre = Genre::where('name', $rowData['genre'])->first();

      if (!$area || !$genre) {
        return redirect()->back()->withErrors(['地域またはジャンルが見つかりません'])->withInput();
      }

      // 新規店舗情報の追加
      Shop::create([
        'name' => $rowData['name'],
        'area_id' => $area->id,
        'genre_id' => $genre->id,
        'about' => $rowData['about'],
        'photo' => $rowData['photo'],
      ]);
    }


    return redirect()->route('admin.dashboard')->with('status', '店舗情報がインポートされました。');
  }
}
