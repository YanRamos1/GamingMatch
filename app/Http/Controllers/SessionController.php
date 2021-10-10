<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('destroy');
    }

    public function create()
    {
        return view('welcome');
    }

    public function store()
    {

        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'O email é obrigatório.',
            'password.required' => 'A senha é obrigatória.',
            'email' => 'Entre com um email válido.',
        ]);

        if (auth()->attempt(['email' => request('email'), 'password' => request('password'), 'blocked' => 0]) == false) {
            $msg = "Email ou senha incorretos, tente novamente.";
            return response()->json(array('error' => $msg), 200);
        }

        User::where('email', '=', request('email'))
            ->update(['last_access_at' => now()]);

        $msg = 'Olá <b>' . auth()->user()->name . '</b>! Seja bem vindo';

        session()->flash('message', 'Olá <b>' . auth()->user()->name . '</b>! Seja bem vindo');
        session()->flash('title', 'Login');
        session()->flash('type', 'success');

        return response()->json(array('success' => $msg), 200);
    }

    public function destroy()
    {


        session()->flash('message', '<b>' . auth()->user()->name . '</b> , até mais!');
        session()->flash('title', 'Sair');
        session()->flash('type', 'success');

        auth()->logout();

        return redirect()->to('/');
    }
    protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|Redirector|void
     */
    public function handleProviderCallback($provider)
    {
        $providerUser =Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $providerUser->getEmail()],
            [
                'name'=>$providerUser->getName() ?? $providerUser->getNickname(),
                'provider_id'=>$providerUser->getId(),
                'provider'=>$provider,
                'avatar'=>$providerUser->getAvatar(),
            ]);
        Auth::login($user);
        return redirect()->to('/');
    }
}
