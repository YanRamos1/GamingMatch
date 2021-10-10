<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'email' => 'Entre com um email válido.',
            'password' => 'As senhas não conferem.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        try {
            $user = User::create(
                [
                    'name' => request('name'),
                    'email' => request('email'),
                    'password' => request('password'),
                    'last_access_at' => now(),
                ]
            );
        } catch (Exception $e) {
            $msg = "Ocorreu um erro ao tentar registrar, tente novamente.";
            return response()->json(array('error' => $msg), 200);
        }

        auth()->login($user);

        $msg = 'Olá <b>' . auth()->user()->name . '</b>! Seja bem vindo';

        session()->flash('message', 'Olá <b>' . auth()->user()->name . '</b>! Seja bem vindo');
        session()->flash('title', 'Login');
        session()->flash('type', 'success');

        return response()->json(array('success' => $msg), 200);
    }
}
