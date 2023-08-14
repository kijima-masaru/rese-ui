<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area', 'genre', 'overview', 'img'];

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id');
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites->contains($user);
    }
}
