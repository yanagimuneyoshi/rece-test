<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'date',
        'time',
        'people',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_ID', 'id');
    }
}
