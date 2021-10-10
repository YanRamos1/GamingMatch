<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wishlist;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!is_null(request('query'))) {
            $users = User::whereRaw('LOWER(name) LIKE ? ', ['%' . trim(strtolower(request('query'))) . '%'])
                ->where('blocked', '0')
                ->get();
        } else {
            $users = array();
        }
        return view('users.index', compact('users'));
    }

    protected $redirectTo = RouteServiceProvider::HOME;

    public function show($id)
    {
        $user = User::find($id);

        $wishlist = Wishlist::User($id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('users.show', ['user' => $user, 'wishlist' => $wishlist]);
    }
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
                'picture'=>$providerUser->getAvatar(),
            ]);
        Auth::login($user);
        return redirect($this->redirectTo);
    }
}
