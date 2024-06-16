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
// Route::get('/home', function () {
//     return view('home');
// })->name('home');

// Route::get('/blog', [
//     BlogController::class,
//     'index'
// ]);

// Route::get('/blog/{id}', [
//     BlogController::class,
//     'detail'
// ])->where('id', '[0-9]+');

// Route::get('/', function () {
//     return view('home');
// });

// Route::get('/users', function () {
//     return ['IT'=>'2 bai', 'Health'=>'3 bai'];
// });

// // response an object
// Route::get('/about-me', function (){
//     return response()->json([
//         "name" => "Nguyen Bui Tuan Linh",
//         "age" => 21
//     ]);
// });

// // response another request = redirect
// Route::get('/alo', function () {
//     return redirect('/about-me');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
