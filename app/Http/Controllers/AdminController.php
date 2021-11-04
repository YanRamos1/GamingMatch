<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Builder as IGDB;
use MarcReichel\IGDBLaravel\Models\Platform as P;
use MarcReichel\IGDBLaravel\Models\Genre as Ge;
use MarcReichel\IGDBLaravel\Models\Game as Ga;
use App\Models\Platform;
use App\Models\Genre;
use App\Models\Game;
use App\Models\Screenshot;
use App\Models\User;
use Exception;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function users()
    {
        $users = User::orderBy('name', 'asc')
            ->with('nivel')
            ->get();
        return view('admin.users', compact('users'));
    }

    public function deleteUser()
    {
        User::find(request('id'))
            ->update(['blocked' => 1]);
    }

    public function promoteUser()
    {
        User::find(request('id'))
            ->update(['role_id' => 1]);
    }

    public function demoteUser()
    {
        User::find(request('id'))
            ->update(['role_id' => 2]);
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function sincornizarJogos()
    {
        $current = Carbon::now()->timestamp;

        try {
            $igdb = new IGDB('games');

            $games = Ga::select(['*'])
                ->with(['cover' => '*', 'screenshots'])
                ->where([
                    ['genres', [null]],
                    ['cover', '!=', null],
                    ['follows', '!=', null],
                    ['rating', '!=', null],
                    ['platforms', ['6', '9', '49', '48']],
                    ['first_release_date', '<', $current]

                ])
                ->orderBy('follows', 'desc')
                ->limit(5000000000000)
                ->get();

            $games2 = Ga::select(['*'])
                ->with(['cover' => '*', 'screenshots'])
                ->where([
                    ['genres', [null]],
                    ['cover', '!=', null],
                    ['follows', '!=', null],
                    ['rating', '!=', null],
                    ['platforms', ['6', '9', '49', '48']],
                    ['first_release_date', '>', $current]

                ])
                ->orderBy('follows', 'desc')
                ->limit(5000000000000)
                ->get();


            foreach ($games as $g => $game_value) {
                try {
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
                                'url' => Str::replaceFirst('thumb', 'cover_big', $game_value['screenshots']['url']),
                            ]);
                        }
                    }
                } catch (Exception $e) {
                }
            }

        } catch (Exception $e) {
            $msg = "Ocorreu um erro ao tentar sincronizar os jogos.";
            return response()->json(array('error' => $msg), 200);
        }

        $msg = "Plataformas sincronizadas com sucesso.";
        return response()->json(array('success' => $msg), 200);
    }

    public function sincornizarGeneros()
    {
        try {
            $igdb = new IGDB('genres');
            $genres = Ge::all();
            $genres_array = array();

            foreach ($genres as $genre => $genre_value) {
                $genres_array[] = [
                    'id' => $genre_value->id,
                    'name' => $genre_value->attributes['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Genre::insert($genres_array);
        } catch (Exception $e) {
            $msg = "Ocorreu um erro ao tentar sincronizar os gêneros.";
            return response()->json(array('error' => $msg), 200);
        }

        $msg = "Gêneros sincronizadas com sucesso.";
        return response()->json(array('success' => $msg), 200);
    }

    public function sincornizarPlataformas()
    {
        try {
            $igdb = new IGDB('platforms');
            $platforms = P::all();
            $platforms_array = array();

            foreach ($platforms as $platform => $platform_value) {
                $platforms_array[] = [
                    'id' => $platform_value->id,
                    'name' => $platform_value->attributes['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Platform::insert($platforms_array);
        } catch (Exception $e) {
            $msg = "Ocorreu um erro ao tentar sincronizar as plataformas.";
            return response()->json(array('error' => $msg), 200);
        }

        $msg = "Plataformas sincronizadas com sucesso.";
        return response()->json(array('success' => $msg), 200);
    }
}
