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
    $reviews = Review::with(['user', 'shop'])->get();
    $shops = Shop::with(['area', 'genre'])->get();
    return view('admin.admin_home', compact('reviews', 'shops'));
  }

  public function deleteReview($id)
  {
    $review = Review::findOrFail($id);
    $review->delete();
    return redirect()->route('admin.dashboard')->with('status', '口コミが削除されました。');
  }

  public function showReviews()
  {
    $reviews = Review::with(['user', 'shop'])->get();
    return view('admin.reviews', compact('reviews'));
  }

  public function importShops(Request $request)
  {
    $request->validate([
      'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $file = $request->file('csv_file');
    $data = array_map('str_getcsv', file($file->getRealPath()));

    $headers = array_map('trim', $data[0]);
    unset($data[0]);

    foreach ($data as $row) {
      $rowData = array_combine($headers, $row);

      $validator = Validator::make($rowData, [
        'name' => 'required|string|max:50',
        'area' => 'required|exists:areas,name',
        'genre' => 'required|exists:genres,name',
        'about' => 'required|string|max:400',
        'photo' => ['nullable', 'url', 'regex:/\.(jpeg|jpg|png)$/i'],
      ], [
        'photo.regex' => '画像URLはjpeg、jpg、またはpng形式である必要があります。'
      ]);


      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
      }

      $area = Area::where('name', $rowData['area'])->first();
      $genre = Genre::where('name', $rowData['genre'])->first();

      if (!$area || !$genre) {
        return redirect()->back()->withErrors(['地域またはジャンルが見つかりません'])->withInput();
      }

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
