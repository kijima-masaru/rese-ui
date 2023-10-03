<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; //新規登録時のメール認証のために追加
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; //お気に入り登録機能のために追加

class User extends Authenticatable implements MustVerifyEmail

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Shopとの関連を定義(1対0もしくは多)
    public function shop()
    {
        return $this->hasMany(Shop::class);
    }

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

    // Reviewとの関連を定義(1対0もしくは多)
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    // お気に入り登録機能のためのリレーション
    public function favoriteShops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'favorites')->withTimestamps();
    }
}
