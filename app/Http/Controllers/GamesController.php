<?php

namespace App\Http\Controllers;

use App\Models\Likedgames;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Builder as IGDB;
use MarcReichel\IGDBLaravel\Models\Game as Ga;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Screenshot;
use App\Models\Year;
use Exception;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;

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
        $gameigdb = $this->popularGames = Ga::select(['*'])->with([
            'artworks' =>['*'],
            'external_games'=>[
                'cover'=>'*',
            ],
            'expansions'=>['*'],
            'game_engines'=>['*'],
            'game_modes'=>['*'],
            'genres'=>['*'],
            'involved_companies'=>['*'],
            'platforms'=>['*'],
            'player_perspectives'=>['*'],
            'screenshots'=>['*'],
            'similar_games'=>[
                'cover',
                'slug',
                'name',
            ],
            'themes'=>['*'],
            'videos'=>['*'],
            'websites'=>['*'],
            'cover'=>[
                'url',
            ],
            'collection'=>['*'],
            'franchises' => ['*'],
            'parent_game'=>['*'],
            'dlcs'=>[
                'name',
                'url',
                'slug',
            ],
            'similar_games.cover'=>['*'],
        ])
            ->where('id', $game->igdb_id)
            ->first();

        $companies = $this->involved = InvolvedCompany::select(
            ['*']
        )->with([
            'company',
            'game',
            'game.genres',
            'game.involved_companies.game',
            'game.cover',
            'game.platforms',
            'company.developed',
            'company.developed.player_perspectives',
            'company.logo',
            'company.developed.genres',
            'company.developed.external_games',
            'company.developed.cover',
            'company.developed.platforms',
            'company.developed.screenshots',
        ])
            ->where([
                ['game',$game->igdb_id],
                ['publisher', true],

            ])
            ->get();

        $wishlist = Wishlist::where('user_id', '=', Auth::id())->where('game_id', '=', $game->id)->first();
        $likedgames = Likedgames::where('user_id', '=', Auth::id())->where('game_id', '=', $game->id)->first();
        $games = Game::select(['igdb_id'])->get();





        return view('games.show', [
            'game' => $game,
            'gameigdb' => $gameigdb,
            'involved_companies' =>$companies,
            'wishlist' =>$wishlist,
            'games' => $games,
            'likedgames'=>$likedgames
        ]);
    }

    public function store()
    {
        $game_validation = Game::where('igdb_id', request('jogo'))->get();

        if (count($game_validation) == 0) {
            $igdb = new IGDB('games');
            $game_value = Ga::with(['cover' => ['*'], 'screenshots'=>['*']])
                ->find(request('jogo'));

            $game = Game::create([
                'name' => $game_value->attributes['name'],
                'released_at' => array_key_exists('first_release_date', $game_value->attributes)
                    ? $game_value->attributes['first_release_date']->toDateTimeString()
                    : null,
                'image' => Str::replaceFirst('thumb', 'cover_big', $game_value['cover']['url']),
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
                    ->with(['cover'=>['*'], 'screenshots'])
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
                            'image' => isset($game_value['cover'])
                                ? Str::replaceFirst('thumb', 'cover_big', $game_value['cover']['url'])
                                : 'https://via.placeholder.com/264x374',
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
