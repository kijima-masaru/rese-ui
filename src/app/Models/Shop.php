<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'overview', 'img'];

    // Favoriteとの関連を定義(1対0もしくは多)
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Reserveとの関連を定義(1対0もしくは多)
    public function reserve()
    {
        return $this->hasMany(Reserve::class);
    }

    // Areaとの関連を定義(1対1)
    public function area()
    {
        return $this->hasOne(Area::class);
    }

    // Genreとの関連を定義(1対1)
    public function genre()
    {
        return $this->hasOne(Genre::class);
    }

    // Reviewとの関連を定義(1対0もしくは多)
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    // 外部キーであるuser_idの設定
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // お気に入り登録機能のためのリレーション
    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites->contains('id', $user->id);
    }
}

