<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;

  // 保存可能なフィールドを指定
  protected $fillable = [
    'shop_id',
    'user_id',
    'rating',
    'comment',
    'image_path',
  ];

  /**
   * Review は特定の Shop に関連する
   */
  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }

  /**
   * Review は特定の User に関連する
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * 画像の完全なURLを取得
   */
  public function getImageUrlAttribute()
  {
    return $this->image_path ? asset('storage/' . $this->image_path) : null;
  }
}
