<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['area', 'shop_id'];

    // 外部キーであるshop_idの設定
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}