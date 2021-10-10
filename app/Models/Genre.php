<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    public function jogos(){
        return $this->belongsToMany(Game::class,
            'games_genres',
            'genre_id',
            'game_id',
        )->withTimestamps();
    }

    protected $fillable = [
        'id',
        'name',
    ];
}
