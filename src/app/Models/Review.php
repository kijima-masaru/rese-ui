<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'comment', 'img', 'status', 'user_id', 'shop_id'];

    // 外部キーであるuser_idの設定
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 外部キーであるshop_idの設定
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
