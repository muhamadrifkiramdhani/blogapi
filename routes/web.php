<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [CustomAuthController::class, 'index']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

//Protect this with middleware
Route::get('/home', [SiteController::class, 'index'])->name('home');
Route::redirect('/articles', '/');

Route::match(['get', 'post'], '/articles/new', [SiteController::class, 'newArticles']);
Route::get('/articles/{id}', [SiteController::class, 'getArticles']);

Route::match(['get', 'patch'], '/articles/update/{id}', [SiteController::class, 'updateArticles']);
Route::get('/articles/delete/{id}', [SiteController::class, 'deleteArticles']);

Route::get('/comments/see', [SiteController::class, 'seeComment'])->name('see_comment');
Route::post('/comments/new', [SiteController::class, 'newComment'])->name('new_comment');