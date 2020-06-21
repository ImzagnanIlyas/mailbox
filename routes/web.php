<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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

/**
 * Sections routes
 */

Route::get('/inbox', function () {
    return view('emails');
})->name('inbox');

Route::get('/search', function () {
    return view('emails');
})->name('search');

Route::get('/important', function () {
    return view('emails');
})->name('important');

Route::get('/sent', function () {
    return view('emails');
})->name('sent');

Route::get('/all', function () {
    return view('emails');
})->name('all');

Route::get('/archive', function () {
    return view('emails');
})->name('archive');

Route::get('/draft', function () {
    return view('emails');
})->name('draft');

Route::get('/category/{title}', function () {
    $tmp = Auth::user()->categories->firstWhere('id', request()->c);
    if($tmp){
        if ($tmp->title == Request::segment(2)) {
            return view('emails');
        }else{
            abort(403);
        }
    }else{
        abort(404);
    }
})->name('category');

/**
 * Email routes
 */

Route::resource('/email', 'EmailController');
Route::resource('/new-email', 'NewEmailController')->only(['index', 'store', 'update', 'destroy']);
Route::resource('/show-email', 'ShowEmailController');
Route::post('/create-category', 'EmailController@storeCategory');

Route::any('/admin/{any?}', 'Admin\AdminController@index')->where('any', '.*')->middleware('auth');

