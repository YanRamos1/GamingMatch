<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use MarcReichel\IGDBLaravel\Builder as IGDB;
use MarcReichel\IGDBLaravel\Models\Game as Ga;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Screenshot;
use App\Models\Year;
use Exception;

class GamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $params = request()->query();
        $platforms = Platform::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('games_platforms')
                ->whereColumn('games_platforms.platform_id', 'platforms.id');
        })->orderBy('name')->get()->toArray();
        $genres = Genre::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('games_genres')
                ->whereColumn('games_genres.genre_id', 'genres.id');
        })->orderBy('name')->get()->toArray();
        $years = Year::all();
        $games = Game::Jogo(request('jogo'))
            ->Plataforma(request('plataforma'))
            ->Genero(request('genero'))
            ->Genero(request('similar'))
            ->join('games_ratings', 'games_ratings.game_id', '=', 'games.id')
            ->Ano(request('ano'))
            ->Ordem(request('order'))
            // ->orderBy('rating', 'desc')
            ->paginate(12)
            ->appends(request()->query());
        return view('games.index', compact('games', 'platforms', 'genres', 'years', 'params'));
    }

    public function show($id)
    {
        $game = Game::find($id);
        return view('games.show', ['game' => $game]);
    }

    public function store()
    {
        $game_validation = Game::where('igdb_id', request('jogo'))->get();

        if (count($game_validation) == 0) {
            $igdb = new IGDB('games');
            $game_value = Ga::with(['cover' => ['image_id'], 'screenshots'])
                ->find(request('jogo'));

            $game = Game::create([
                'name' => $game_value->attributes['name'],
                'released_at' => array_key_exists('first_release_date', $game_value->attributes)
                    ? $game_value->attributes['first_release_date']->toDateTimeString()
                    : null,
                'image' => array_key_exists('cover', $game_value->relations->toArray())
                    ? 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $game_value->relations['cover']->attributes['image_id'] . '.jpg'
                    : null,
                'description' => array_key_exists('summary', $game_value->attributes)
                    ? $game_value->attributes['summary']
                    : null,

                'igdb_id' => $game_value->attributes['id'],


            ]);

            if (array_key_exists('genres', $game_value->attributes)) {
                $game->generos()->attach($game_value->attributes['genres']);
            }

            if (array_key_exists('platforms', $game_value->attributes)) {
                $game->plataformas()->attach($game_value->attributes['platforms']);
            }

            if (array_key_exists('similar_games', $game_value->attributes)) {
                $game->plataformas()->attach($game_value->attributes['similar_games']);
            }

            if (array_key_exists('screenshots', $game_value->relations->toArray())) {
                foreach ($game_value->relations->toArray()['screenshots'] as $screenshot => $screnshot_value) {
                    Screenshot::create([
                        'game_id' => $game->id,
                        'url' => 'https://images.igdb.com/igdb/image/upload/t_original/' . $screnshot_value['image_id'] . '.jpg',
                    ]);
                }
            }
        } else {
            $game = $game_validation[0];
        }

        session()->flash('message', '<b>' . $game->name . '</b> cadastrado com sucesso.');
        session()->flash('title', 'Cadastro');
        session()->flash('type', 'success');

        return redirect()->route('games.show', ['game' => $game]);
    }

    public function search()
    {
        $games = array();
        if (!is_null(request('query'))) {
            try {
                $igdb = new IGDB('games');
                $games_array = Ga::search(request('query'))
                    ->with(['cover' => ['image_id'], 'screenshots'])
                    ->take(50)
                    ->get();
                foreach ($games_array as $g => $game_value) {
                    try {
                        $games[] = [
                            'igdb_id' => $game_value->attributes['id'],
                            'name' => $game_value->attributes['name'],
                            'released_at' => array_key_exists('first_release_date', $game_value->attributes)
                                ? $game_value->attributes['first_release_date']->toDateTimeString()
                                : null,
                            'image' => array_key_exists('cover', $game_value->relations->toArray())
                                ? 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $game_value->relations['cover']->attributes['image_id'] . '.jpg'
                                : null,
                            'description' => array_key_exists('summary', $game_value->attributes)
                                ? $game_value->attributes['summary']
                                : null,
                        ];
                    } catch (Exception $e) {
                        dd($e);
                    }
                }
            } catch (Exception $e2) {
                dd($e2);
            }
        }
        return view('games.create', compact('games'));
    }
}
