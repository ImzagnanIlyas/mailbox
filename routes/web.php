<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/inbox', function () {
    return view('inbox');
});

/**
 * Email routes
 */

Route::resource('/email', 'EmailController');
Route::resource('/new-email', 'NewEmailController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('/show-email', 'ShowEmailController');

Route::any('/admin/{any?}', 'Admin\AdminController@index')->where('any', '.*')->middleware('auth');

