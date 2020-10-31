<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

Route::get('/', HomeController::class)->name('home');

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit']);
Route::post('/posts', [PostController::class, 'save']);
Route::delete('/posts/{post:slug}', [PostController::class, 'destroy']);

Route::get('/social/auth/{provider}', [AuthController::class, 'redirect']);
Route::get('/social/auth/{provider}/callback', [AuthController::class, 'callback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/me', [UserController::class, 'edit']);
Route::get('/users/{user:slug}', [UserController::class, 'show']);
