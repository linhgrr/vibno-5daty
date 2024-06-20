<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VotesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

Auth::routes();

Route::get('/',[PostsController::class, 'index'])->name('posts');
Route::get('/home', [PostsController::class, 'index'])->name('posts');

Route::get('/posts', [PostsController::class, 'index'])->name('posts');
Route::get('/posts/{id}', [PostsController::class, 'show'])
    ->name('post.show')
    ->where('id', '[0-9]+');


Route::get('/posts/create', [PostsController::class, 'create'])->name('post.create')->middleware('auth');
Route::post('/posts', [PostsController::class, 'store'])->name('post.store')->middleware('auth');
Route::post('/posts/{id}/edit-done', [PostsController::class, 'edit'])->name('post.edit');
Route::get('/posts/{id}/edit', [PostsController::class, 'update'])->name('post.update');
Route::post('/posts/{id}/delete', [PostsController::class, 'delete'])->name('post.delete');
Route::post('posts/search', [PostsController::class, 'search'])->name('post.search');
//Comments
Route::post('comments', [CommentsController::class, 'store'])->middleware('auth');

// profile
Route::get('/users/{id}', [UsersController::class, 'show'])
    ->name('user.show')
    ->where('id', '[0-9]+')->middleware('auth');
Route::get('/users/update', [UsersController::class, 'update'])->middleware('auth');
Route::post('profile/avatar', [UsersController::class, 'updateAvatar'])->name('avatar.update')->middleware('auth');
Route::post('users/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware('auth');
//follow
Route::post('/follows/follow', [FollowsController::class, 'follow'])->middleware('auth');
Route::post('/follows/unfollow', [FollowsController::class, 'unfollow'])->middleware('auth');

//vote
Route::post('/votes/upvote', [VotesController::class, 'upvote'])->middleware('auth');
Route::post('/votes/downvote', [VotesController::class, 'downvote'])->middleware('auth');
Route::post('/votes/unvote', [VotesController::class, 'unvote'])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\PostsController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\PostsController::class, 'index'])->name('home');
