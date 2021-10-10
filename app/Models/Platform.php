<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    public function jogos(){
        return $this->belongsToMany(Game::class,
            'games_platforms',
            'platform_id',
            'game_id',
        )->withTimestamps();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];
}
