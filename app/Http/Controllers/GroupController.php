<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Post;
use Auth;
use Illuminate\Http\Request;
use OhKannaDuh\Groups\Model\Group;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;

class GroupController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::select(['*'])->with('posts')->get();
        return view('groups.index', compact('groups'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create($id)
    {
        $game = IGDBGame::find($id);
        $localgame = Game::where('igdb_id', $id)->first();
        Group::create([
            "id" =>$id,
            "name" => "Community $game->name",
            "image" => $localgame->image,
            "key" =>  $game->id
        ]);
        return redirect("/games/$localgame->id");
    }

    //Adds a user to a group
    public function addToGroup($id)
    {
        $game = Game::where('igdb_id', $id)->first();
        $group = Group::find($id);
        $user = Auth::user();
        $group->addUser($user);
        return redirect("/groups/show/{$group->id}");
    }

    public function show($id){
        $game = Game::where('igdb_id', $id)->first();
        $user = Auth::user();
        $group = Group::find($game->igdb_id);
        $users = $group->users;
        $posts = Post::where('group_id', $group->id)->get();
        return view('groups.show',[
            'group' => $group,
            'users' => $users,
            'posts' => $posts,
            'user' => $user,
        ]);
    }
    //Removes a user from a group
    public function removeFromGroup($id)
    {
        $game = Game::find($id);
        $group = Group::find($id);
        $user = Auth::user();
        $group->removeUser($user);
        return redirect("/groups/show/{$group->id}");
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
