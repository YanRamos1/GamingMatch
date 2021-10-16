<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Likedgames;
use App\Models\Platform;
use App\Models\Wishlist;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikedgamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $likedgames = Likedgames::User(auth()->user()->id)->get();

        return view('likedgames.index', compact('likedgames', 'platforms', 'genres', 'years', 'params'));
    }

    public function store()
    {
        $likedgames = Likedgames::where('user_id', '=', auth()->id())
            ->where('game_id', '=', request('game'))
            ->get();

        if (count($likedgames) == 0) {
            try {
                Likedgames::create([
                    'user_id' => auth()->id(),
                    'game_id' => request('game'),
                ]);
            } catch (Exception $e) {
                $msg = "Ocorreu um erro ao tentar curtir.";
                return response()->json(array('error' => $msg), 200);
            }
        } else {
            $msg = '<b>' .  auth()->user()->name . '</b>, Não é possivel curtir o jogo duas vezes.';
            return response()->json(array('error' => $msg), 200);
        }

        $game = Game::find(request('game'));

        session()->flash('message', '<b>' . $game->name . '</b> Curtido.');
        session()->flash('title', 'Curtir');
        session()->flash('type', 'success');

        $msg = '<b>' . $game->name . '</b> Curtido';
        return response()->json(array('success' => $msg), 200);
    }

    public function delete()
    {
        $likedgames = Likedgames::where('user_id', Auth::id())
            ->where('game_id', '=', request('game'))
            ->get();


        if (count($likedgames) != 0) {
            try {
                $likedgames = Likedgames::where('user_id', '=', Auth::id())->where('game_id', '=', request('game'))->first();
                $likedgames->delete();
            } catch (Exception $e) {
                $msg = "Ocorreu um erro ao tentar remover este jogo da lista de desejos.";
                return response()->json(array('error' => $msg), 200);
            }
        } else {
            $msg = '<b>' .  auth()->user()->name . '</b>, não é possível adirecionar o mesmo jogo duas vezes à lista de desejos.';
            return response()->json(array('error' => $msg), 200);
        }

        $game = Game::find(request('game'));

        session()->flash('message', '<b>' . $game->name . '</b> removido da lista de desejos com sucesso.');
        session()->flash('title', 'Lista de Desejos');
        session()->flash('type', 'success');

        $msg = '<b>' . $game->name . '</b> removido da lista de desejos com sucesso.';
        return response()->json(array('success' => $msg), 200);
    }
}
