<?php

use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;

Auth::routes();

Route::get('/', [PagesController::class, 'index']);
Route::get('/about', [PagesController::class, 'about'])->name('about');

Route::get('/posts', [PostsController::class, 'index'])->name('posts');
Route::get('/posts/{id}', [PostsController::class, 'show'])
    ->name('post.{id}')
    ->where('id', '[0-9]+');
Route::get('/posts/create', [PostsController::class, 'create'])->name('post.create')->middleware('auth');
Route::post('/posts', [PostsController::class, 'store'])->name('post.store')->middleware('auth');
//Comments
Route::post('comments', [CommentsController::class, 'store'])->middleware('auth');

// profile
Route::get('/users/{id}', [PostsController::class, 'show']);
