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
    return redirect()->route('inbox');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Sections routes
 */

Route::get('/inbox', function () {
    return view('emails');
})->name('inbox')->middleware('auth');

Route::get('/search', function () {
    return view('emails');
})->name('search')->middleware('auth');

Route::get('/important', function () {
    return view('emails');
})->name('important')->middleware('auth');

Route::get('/sent', function () {
    return view('emails');
})->name('sent')->middleware('auth');

Route::get('/all', function () {
    return view('emails');
})->name('all')->middleware('auth');

Route::get('/archive', function () {
    return view('emails');
})->name('archive')->middleware('auth');

Route::get('/draft', function () {
    return view('emails');
})->name('draft')->middleware('auth');

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
})->name('category')->middleware('auth');

Route::get('/trash', function () {
    return view('emails');
})->name('trash')->middleware('auth');


/**
 * Email routes
 */

Route::resource('/email', 'EmailController')->middleware('auth');
Route::resource('/new-email', 'NewEmailController')->only(['index', 'store', 'update', 'destroy'])->middleware('auth');
Route::resource('/show-email', 'ShowEmailController')->middleware('auth');
Route::post('/create-category', 'EmailController@storeCategory')->middleware('auth');

Route::any('/admin/{any?}', 'Admin\AdminController@index')->where('any', '.*')->middleware('auth');

