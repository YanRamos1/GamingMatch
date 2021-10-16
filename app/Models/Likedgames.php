<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likedgames extends Model
{
    use HasFactory;

    public function scopeUser($query, $usuario)
    {
        if (!is_null($usuario)) {
            return $query->whereHas('usuario', function ($query) use ($usuario) {
                $query->where('users.id', $usuario);
            });
        }
        return $query;
    }

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
        'user_id',
        'game_id',
    ];
}
