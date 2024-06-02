<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shop extends Model
{
  protected $fillable = ['name', 'photo', 'about', 'area_id', 'genre_id'];

  public function area()
  {
    return $this->belongsTo(Area::class);
  }

  public function genre()
  {
    return $this->belongsTo(Genre::class);
  }

  protected $appends = ['is_favorite'];

  public function getIsFavoriteAttribute()
  {
    $user = Auth::user();
    if ($user) {
      return $user->favorites->pluck('shop_id')->contains($this->id);
    }
    return false;
  }

  public function reservations()
  {
    return $this->hasMany(Reserve::class, 'shop_ID', 'id');
  }
}
