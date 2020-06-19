<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', 'Admin\UserController');
Route::apiResource('roles', 'Admin\RoleController');
Route::apiResource('permissions', 'Admin\PermissionController');

Route::post('admin/new-user', 'Admin\UserController@store');
Route::resource('admin/emails', 'Admin\EmailsController');
