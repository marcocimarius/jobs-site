<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AccountController;

Route::get('/', [PostsController::class, 'show_threads']);
Route::get('/search', [PostsController::class, 'search']);
Route::get('/about', [PostsController::class, 'about']);
Route::get('/thread/{id}', [PostsController::class, 'show_thread']);
Route::post('/create_comment', [PostsController::class, 'create_comment']);
Route::post('/create_reply', [PostsController::class, 'create_reply']);
Route::post('/thread/{id}', [PostsController::class, 'create_secondary_reply']);
Route::get('/create', [PostsController::class, 'show_create_thread']);
Route::post('/create', [PostsController::class, 'create_thread']);
Route::get('/update_thread', [PostsController::class, 'show_update_thread']);
Route::put('/update_thread', [PostsController::class, 'update_thread']);
Route::delete('/delete_thread', [PostsController::class, 'delete_thread']);
Route::delete('/destroy_thread', [PostsController::class, 'destroy_thread']);
Route::delete('/delete_reply', [PostsController::class, 'delete_reply']);
Route::delete('/delete_comment', [PostsController::class, 'delete_comment']);
Route::get('/sort_newest', [PostsController::class, 'sort_newest']);
Route::get('/sort_oldest', [PostsController::class, 'sort_oldest']);
Route::get('/sort_comments_newest', [PostsController::class, 'sort_comments_newest']);
Route::get('/sort_comments_oldest', [PostsController::class, 'sort_comments_oldest']);
Route::put('/', [PostsController::class, 'delete_number']);
Route::put('/ban_comment', [PostsController::class, 'ban_comment']);
Route::put('/ban_reply', [PostsController::class, 'ban_reply']);
Route::put('/ban_post1', [PostsController::class, 'ban_post1']);
Route::put('/ban_post2', [PostsController::class, 'ban_post2']);

Route::post('/signup', [AuthController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/account/{id}', [AccountController::class, 'show']);
Route::get('/update_account', [AccountController::class, 'show_update']);
Route::put('/update_account', [AccountController::class, 'update']);
Route::put('/make_admin', [AccountController::class, 'make_admin']);
Route::post('/follow', [AccountController::class, 'follow']);
Route::delete('/unfollow', [AccountController::class, 'unfollow']);

Route::get('/logout', function() {
    if(session()->has('id')) {
        session()->pull('id');
        session()->pull('login');
        session()->pull('email');
        session()->pull('role');
        session()->pull('photo');
        session()->pull('ban_until');
    }
    return redirect('/');
});
Route::get('/signup', function() {
    if(session()->has('id')) {
        return redirect('/');
    }
    return view('/signup');
});
Route::get('/login', function() {
    if(session()->has('id')) {
        return redirect('/');
    }
    return view('/login');
});