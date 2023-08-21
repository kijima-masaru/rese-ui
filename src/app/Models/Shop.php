<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area', 'genre', 'overview', 'img'];

    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites->contains('id', $user->id);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // 外部キーであるuser_idの設定
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
