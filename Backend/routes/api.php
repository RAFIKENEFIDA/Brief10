<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentaireController;

// Routers du postController

Route::group([
    'middleware' => 'jwt.verify',
    'namespace' => 'App\Http\Controllers',

], function () {
    Route::resource('posts', 'PostController');

    Route::post('posts/showAllPostWithName', [PostController::class, 'showAllPostWithName']);
});

Route::post('posts/show', [PostController::class, 'show']);
// Routers du UserController

Route::group([
    // 'middleware' => 'jwt.verify',
    'namespace' => 'App\Http\Controllers',

], function () {
    Route::resource('users', 'UserController');

    Route::get('showCommentaires/{user}', [UserController::class, 'showCommentaires']);

    Route::get('showPosts/{user}', [UserController::class, 'showPosts']);
});

// Routers du CommentaireController



Route::group([
    'middleware' => 'jwt.verify',
    'namespace' => 'App\Http\Controllers',

], function () {
    Route::resource('Commentaires', 'CommentaireController');
    Route::post('commentaires/show', [CommentaireController::class, 'show']);
});

// Routers du AuthController

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth',
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('get_user', [AuthController::class, 'get_user']);
});