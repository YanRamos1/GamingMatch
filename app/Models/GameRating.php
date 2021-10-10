<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRating extends Model
{
    use HasFactory;

    protected $table = 'games_ratings';

    public function jogo()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }
}
