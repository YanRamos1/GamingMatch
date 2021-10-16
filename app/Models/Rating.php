<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;


class Rating extends Model
{
    use CanBeLiked;
    use HasFactory;

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jogo(){
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'commentary',
        'user_id',
        'game_id',
    ];
}
