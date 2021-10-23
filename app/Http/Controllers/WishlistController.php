<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Year;
use App\Models\Wishlist;
use Exception;

class WishlistController extends Controller
{
    //
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
        $wishlist = Wishlist::User(auth()->user()->id)->get();
        // dd($wishlist);
        return view('wishlist.index', compact('wishlist', 'platforms', 'genres', 'years', 'params'));
    }

    public function store()
    {
        $wishlist = Wishlist::where('user_id', '=', auth()->id())
            ->where('game_id', '=', request('game'))
            ->get();

        if (count($wishlist) == 0) {
            try {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'game_id' => request('game'),
                ]);
            } catch (Exception $e) {
                $msg = "Ocorreu um erro ao tentar adicioanr este jogo à lista de desejos.";
                return response()->json(array('error' => $msg), 200);
            }
        } else {
            $msg = '<b>' .  auth()->user()->name . '</b>, não é possível adicionar o mesmo jogo duas vezes à lista de desejos.';
            return response()->json(array('error' => $msg), 200);
        }

        $game = Game::find(request('game'));

        session()->flash('message', '<b>' . $game->name . '</b> adicionado à lista de desejos com sucesso.');
        session()->flash('title', 'Lista de Desejos');
        session()->flash('type', 'success');

        $msg = '<b>' . $game->name . '</b> adicionado à lista de desejos com sucesso.';
        return response()->json(array('success' => $msg), 200);
    }

    public function delete()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('game_id', '=', request('game'))
            ->get();


        if (count($wishlist) != 0) {
            try {
                $wishlist = Wishlist::where('user_id', '=', Auth::id())->where('game_id', '=', request('game'))->first();
                $wishlist->delete();
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
