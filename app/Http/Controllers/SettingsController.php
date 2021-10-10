<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsController extends Controller
{
    //WhislistController
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('settings.index');
    }

    public function user()
    {
        return view('settings.user', ['user' => auth()->user()]);
    }

    public function atualizarAvatar()
    {
        $this->validate(request(), [
            'avatar' => 'required|mimes:jpg,jpeg,png|max:256',
        ], [
            'avatar.required' => 'É necessário selecionar um arquivo válido.',
            'mimes' => 'O arquvio deve ser uma imagem válida do tipo jpg, jpeg ou png.',
            'max' => 'O arquvio deve ter menos de 256kB.'
        ]);

        $data = file_get_contents(request('avatar'));
        $avatar = 'data:image/' .  request('avatar')->extension() . ';base64,' . base64_encode($data);

        auth()->user()->update([
            'avatar' => $avatar,
            'updated_at' => now()
        ]);

        $msg = '<b>' . auth()->user()->name . '</b>, avatar alterado com sucesso.';

        session()->flash('message', '<b>' . auth()->user()->name . '</b>, avatar alterado com sucesso.');
        session()->flash('title', 'Alterar Avatar');
        session()->flash('type', 'success');

        return response()->json(array('success' => $msg), 200);
    }

    public function atualizarSenha()
    {

        $this->validate(request(), [
            'current' => 'required',
            'password' => 'required|confirmed'
        ], [
            'current.required' => 'A senha atual é obrigatória.',
            'password.required' => 'A nova senha é obrigatória.',
            'password' => 'As senhas não conferem.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        if (Hash::check(request('current'), auth()->user()->password)) {

            User::find(auth()->user()->id)
                ->update([
                    // 'password' => Hash::make(request('password')), // Não entendi, não precisei fazer o hash da senha, ela já é salva criptografada aqui
                    'password' => request('password'),
                    'updated_at' => now()
                ]);

            $msg = '<b>' . auth()->user()->name . '</b>, senha alterada com sucesso.';

            session()->flash('message', '<b>' . auth()->user()->name . '</b>, senha alterada com sucesso.');
            session()->flash('title', 'Alterar Senha');
            session()->flash('type', 'success');

            return response()->json(array('success' => $msg), 200);
        } else {
            $msg = '<b>' . auth()->user()->name . '</b>, a senha digitada com confere com a senha atual.';

            session()->flash('message', '<b>' . auth()->user()->name . '</b>, a senha digitada com confere com a senha atual.');
            session()->flash('title', 'Alterar Senha');
            session()->flash('type', 'error');

            return response()->json(array('success' => $msg), 200);
        }
    }

    public function atualizarRedesSociais()
    {
        auth()->user()->update([
            'about' => request('about'),
            'twitter' => request('twitter'),
            'twitch' => request('twitch'),
            'instagram' => request('instagram'),
            'facebook' => request('facebook'),
            'updated_at' => now()
        ]);

        $msg = '<b>' . auth()->user()->name . '</b>, redes sociais alteradas com sucesso.';

        session()->flash('message', '<b>' . auth()->user()->name . '</b>, redes sociais alteradas com sucesso.');
        session()->flash('title', 'Alterar Redes Sociais');
        session()->flash('type', 'success');

        return response()->json(array('success' => $msg), 200);
    }

}
