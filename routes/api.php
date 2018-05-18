<?php

use Illuminate\Http\Request;

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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

/*****registration*****/

Route::get('/register', 'AuthenticateController@showRegistrationForm');
////params : 
//email , password , password_confirmation ,registration_token ,governorate_id
Route::post('/register', 'AuthenticateController@register');


/******login******/

Route::get('/login', 'AuthenticateController@showLoginForm');
////params : 
//email , password , registration_token
Route::post('/login', 'AuthenticateController@login');

/******logout******/
Route::get('/logout', 'AuthenticateController@logout');

