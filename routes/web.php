<?php

use App\Http\Controllers\LikedGamesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishlistController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SessionController::class, 'create']);

Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/#login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::get('/logout', [SessionController::class, 'destroy']);
Route::get('/login/{provider}', [SessionController::class, 'redirectToProvider'])->name('social.login');
Route::get('/login/{provider}/callback', [SessionController::class, 'handleProviderCallback'])->name('social.callback');


Route::get('/games', [GamesController::class, 'index']);
Route::get('/games/search', [GamesController::class, 'search'])->name('games.search');
Route::post('/games', [GamesController::class, 'store']);
Route::get('/games/{game}', [GamesController::class, 'show'])->name('games.show');
Route::get('/games/like/{id}', [UsersController::class, 'likegame'])->name('games.like');
Route::get('/games/unlike/{id}', [UsersController::class, 'unlikegame'])->name('games.unlike');


Route::get('/news', [NewsController::class, 'Index'])->name('news.index');





Route::post('/review', [RatingController::class, 'store']);
Route::delete('/review', [RatingController::class, 'delete']);

Route::get('/settings/user', [SettingsController::class, 'user']);
Route::post('/settings/user', [SettingsController::class, 'atualizarAvatar']);
Route::put('/settings/user/senha', [SettingsController::class, 'atualizarSenha']);
Route::put('/settings/user/social', [SettingsController::class, 'atualizarRedesSociais']);

Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::get("/users/add/{id}", [UsersController::class, 'addFriend'])->name('add.friend');
Route::get("/users/accept/{id}", [UsersController::class, 'acceptFriend'])->name('accept.friend');
Route::get("/users/delete/{id}", [UsersController::class, 'deleteFriend'])->name('delete.friend');
Route::get("/users/deny/{id}", [UsersController::class, 'denyFriend'])->name('deny.friend');
Route::get("/users/block/{id}", [UsersController::class, 'blockFriend'])->name('block.friend');
Route::get("/users/unblock/{id}", [UsersController::class, 'unblockFriend'])->name('unblock.friend');

Route::get('/admin/users', [AdminController::class, 'users']);
Route::delete('/admin/users', [AdminController::class, 'deleteUser']);
Route::put('/admin/users/promote', [AdminController::class, 'promoteUser']);
Route::put('/admin/users/demote', [AdminController::class, 'demoteUser']);
Route::get('/admin/settings', [AdminController::class, 'settings']);
Route::post('/admin/settings/plataforma', [AdminController::class, 'sincornizarPlataformas']);
Route::post('/admin/settings/genero', [AdminController::class, 'sincornizarGeneros']);
Route::post('/admin/settings/jogo', [AdminController::class, 'sincornizarJogos']);

Route::get('/wishlist', [WishlistController::class, 'index']);
Route::post('/wishlist', [WishlistController::class, 'store']);
Route::delete('/wishlist-delete', [WishlistController::class, 'delete']);

Route::get('/liked', [LikedGamesController::class, 'index']);
Route::post('/liked', [LikedGamesController::class, 'store']);
Route::delete('/liked', [LikedGamesController::class, 'delete']);


Route::get('/rating/like/{id}', [UsersController::class, 'likeRating'])->name('like.rating');
Route::get('/rating/unlike/{id}', [UsersController::class, 'unlikeRating'])->name('unlike.rating');


Route::get('/users/follow/{id}', [UsersController::class, 'follow'])->name('users.follow');
Route::get('/users/unfollow/{id}', [UsersController::class, 'unfollow'])->name('users.unfollow');


Route::get('/games/group/create/{id}', [GroupController::class, 'create'])->name('groups.create');
Route::get('/games/group/enter/{id}', [GroupController::class, 'addToGroup'])->name('groups.addUser');
Route::get('/games/group/leave/{id}', [GroupController::class, 'removeFromGroup'])->name('groups.removeUser');
Route::get('/groups/show/{id}', [GroupController::class, 'show'])->name('groups.show');
Route::get('/groups', [GroupController::class, 'index']);


Route::get('/groups/posts/create/', [PostController::class, 'store'])->name('posts.store');
Route::get('/groups/posts/{id}', [PostController::class, 'createPost'])->name('posts.create');
Route::get('/groups/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/groups/posts/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/groups/posts/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
Route::get('/groups/posts/update/{id}', [PostController::class, 'update'])->name('posts.update');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/groups/posts/{id}/vote', [UsersController::class, 'togglevote'])->name('posts.togglevote');
Route::get('/groups/posts/{id}/downvote', [UsersController::class, 'downvote'])->name('posts.downvote');
Route::get('/groups/posts/{id}/uppost', [UsersController::class, 'upvote'])->name('posts.upvote');
Route::get('/groups/posts/{id}/cancel', [UsersController::class, 'cancelVote'])->name('posts.cancelvote');


