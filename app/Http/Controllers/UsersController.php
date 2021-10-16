<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Rating;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\LikedGames;
use App\Providers\RouteServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Multicaret\Acquaintances\Models\Friendship;
use Multicaret\Acquaintances\Traits\Friendable;


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

        $friendshipsReceived = Friendship::select(['*'])
            ->where('recipient_id',Auth::user()->id)
            ->where('sender_id',$user->id)
            ->first();

        $friendshipSend = Friendship::select(['*'])
            ->where('recipient_id',$user->id)
            ->where('sender_id',Auth::user()->id)
            ->first();

        $allfriends = Friendship::select(['*'])
            ->where('status','accepted')
            ->where('sender_id',Auth::user()->id)->where('recipient_id',$user->id)->get();



        $wishlist = Wishlist::User($id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $likedgames = LikedGames::User($id)
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('users.show', [
            'user' => $user,
            'wishlist' => $wishlist,
            'likedgames'=>$likedgames,
            'friendshipsReceived'=>$friendshipsReceived,
            'friendshipSend'=>$friendshipSend,
            'allfriends'=>$allfriends,

        ]);
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

    public function addFriend ($id){
        $user = User::find($id);
        (Auth::user())->befriend($user);
        return redirect("/users/$user->id");
    }
    public function blockFriend ($id){
        $user = User::find($id);
        (Auth::user())->blockFriend($user);
        return redirect("/users/$user->id");
    }
    public function unblockFriend ($id){
        $user = User::find($id);
        (Auth::user())->unblockFriend($user);
        return redirect("/users/$user->id");
    }
    public function deleteFriend ($id){
        $user = User::find($id);
        $myaccount_id = Auth::user()->id;
        (Auth::user())->unfriend($user);
        return redirect("/users/$user->id");
    }
    public function acceptFriend ($id){
        $user = User::find($id);
        $myaccount_id = Auth::user()->id;
        (Auth::user())->acceptFriendRequest($user);
        return redirect("/users/$myaccount_id");
    }
    public function denyFriend ($id){
        $user = User::find($id);
        $myaccount_id = Auth::user()->id;
        (Auth::user())->denyFriendRequest($user);
        return redirect("/users/$myaccount_id");
    }

    public function likeRating ($id){
        $rating = Rating::find($id);
        Auth::user()->like($rating);
        return redirect("/games/$rating->game_id");
    }

    public function unlikeRating ($id){
        $rating = Rating::find($id);
        Auth::user()->unlike($rating);
        return redirect("/games/$rating->game_id");
    }

    public function follow ($id){
        $user = User::find($id);
        (Auth::user())->follow($user);
        return redirect("/users/$user->id");
    }
    public function unfollow ($id){
        $user = User::find($id);
        (Auth::user())->unfollow($user);
        return redirect("/users/$user->id");
    }
    public function likegame ($id){
        $game = Game::find($id);
        (Auth::user())->like($game);
        return redirect("/games/$game->id");
    }
    public function unlikegame ($id){
        $game = Game::find($id);
        (Auth::user())->unlike($game);
        return redirect("/games/$game->id");
    }



}
