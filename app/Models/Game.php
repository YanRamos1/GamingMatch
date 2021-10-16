<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;

class Game extends Model
{
    use HasFactory;
    use CanBeLiked;

    public function scopeJogo($query, $jogo)
    {
        if (!is_null($jogo)) {
            // return $query->where('name', 'like', '%' . $jogo . '%');
            return $query->whereRaw('LOWER(name) LIKE ? ', ['%'.trim(strtolower($jogo)).'%']);
        }
        return $query;
    }

    public function scopeGenero($query, $genero)
    {
        if (!is_null($genero)) {
            return $query->whereHas('generos', function ($query) use ($genero) {
                $query->where('games_genres.genre_id', $genero);
            });
        }
        return $query;
    }

    public function scopePlataforma($query, $plataforma)
    {
        if (!is_null($plataforma)) {
            return $query->whereHas('plataformas', function ($query) use ($plataforma) {
                $query->where('games_platforms.platform_id', $plataforma);
            });
        }
        return $query;
    }

    public function scopeAno($query, $ano)
    {
        if (!is_null($ano)) {
            return $query->whereYear('released_at', $ano);
        }
        return $query;
    }

    public function scopeOrdem($query, $ordenacao)
    {
        if (!is_null($ordenacao)) {
            switch ($ordenacao) {
                case 'avaliacao':
                    return $query->orderBy('rating', 'desc');
                case 'nome':
                    return $query->orderBy('games.name', 'asc');
                case 'novo':
                    return $query->orderBy('games.released_at', 'desc');
                case 'antigo':
                    return $query->orderBy('games.released_at', 'asc');
                default:
                    return $query->orderBy('rating', 'desc');
            }
        } else {
            return $query->orderBy('rating', 'desc');
        }
    }

    public function generos()
    {
        return $this->belongsToMany(
            Genre::class,
            'games_genres',
            'game_id',
            'genre_id',
        )->withTimestamps();
    }

    public function plataformas()
    {
        return $this->belongsToMany(
            Platform::class,
            'games_platforms',
            'game_id',
            'platform_id',
        )->withTimestamps();
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function avaliacoes()
    {
        return $this->hasMany(Rating::class)
            ->orderBy('updated_at', 'desc');
    }

    public function screenshots()
    {
        return $this->hasMany(Screenshot::class);
    }

    public function rating()
    {
        return $this->hasOne(GameRating::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'released_at',
        'image',
        'description',
        'igdb_id',
    ];
}
