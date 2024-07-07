<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Fillable properties
    protected $fillable = [
        'user_id',  // 追加
        'shop_id',
        'date',
        'time',
        'people'
    ];
}
