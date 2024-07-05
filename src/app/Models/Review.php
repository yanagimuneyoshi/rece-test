<?php

// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;

  protected $fillable = [
    'shop_id',
    'user_id',
    'rating',
    'comment',
  ];

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
