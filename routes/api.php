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


/*****registration*****/

Route::get('/register', 'AuthenticateController@showRegistrationForm');
////params : 
// *name , *email , *password , *password_confirmation , *positionID , managerID(if positionID ==2)
Route::post('/register', 'AuthenticateController@register');


/******login******/

Route::get('/login', 'AuthenticateController@showLoginForm');
////params : 
// *email , *password 
Route::post('/login', 'AuthenticateController@login');

/******logout******/
Route::get('/logout', 'AuthenticateController@logout');

/********profile********/
Route::get('/profile/edit', 'ProfileController@editProfile');
////params : 
// *token , *name , *email
Route::post('/profile/update', 'ProfileController@updateProfile');


///////////////manager routes //////////////

/***********list manager's sales men***********/

Route::get('/mySalesMen', 'ManagerController@listMySalesMen');
Route::get('/mySalesMen/evaluate/{id}', 'ManagerController@evaluateSalesManForm');
//params : 
// * performance_id

Route::post('/mySalesMen/evaluate/{id}', 'ManagerController@evaluateSalesMan');


//////////////sales man routes /////////////

