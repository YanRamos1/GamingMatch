<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Game;
use Exception;

class RatingController extends Controller
{
    //
    public function store(Request $request)
    {

        $this->validate(request(), [
            'avaliacao' => 'required',
            'comentario' => 'required',
        ], [
            'avaliacao.required' => 'A avaliação é obrigatória.',
            'comentario.required' => 'O comentário é obrigatório.',
        ]);

        $rating = Rating::where('user_id', '=', auth()->id())
            ->where('game_id', '=', request('game'))
            ->get();

        if (count($rating) == 0) {
            try {
                Rating::create([
                    'rating' => request('avaliacao'),
                    'commentary' => request('comentario'),
                    'user_id' => auth()->id(),
                    'game_id' => request('game'),
                ]);
            } catch (Exception $e) {
                $msg = "Ocorreu um erro ao tentar avaliar, tente novamente.";
                return response()->json(array('error' => $msg), 200);
            }
        } else {
            $msg = '<b>' .  auth()->user()->name . '</b>, não é possível avaliar o mesmo jogo duas vezes.';
            return response()->json(array('error' => $msg), 200);
        }

        $game = Game::find(request('game'));

        session()->flash('message', '<b>' . $game->name . '</b> avaliado com sucesso.');
        session()->flash('title', 'Avaliação');
        session()->flash('type', 'success');

        $msg = '<b>' . $game->name . '</b> avaliado com sucesso.';
        return response()->json(array('success' => $msg), 200);
    }

    public function delete()
    {   
        $rating = Rating::find(request('id'));
        if (auth()->user()->isAdmin() || $rating->user_id == auth()->user()->id) {
            $rating->delete();
        } else {
            $msg = '<b>' .  auth()->user()->name . '</b>, não é possível remover a avaliação do jogo.';
            return response()->json(array('error' => $msg), 200);
        }

        session()->flash('message', '<b>' . auth()->user()->name . '</b>, avaliação removida com sucesso.');
        session()->flash('title', 'Avaliação');
        session()->flash('type', 'success');

        $msg = '<b>' . auth()->user()->name . '</b>, avaliação removida com sucesso.';
        return response()->json(array('success' => $msg), 200);
    }
}
