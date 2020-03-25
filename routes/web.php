<?php

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

// route to login user
Route::post('login', 'UserController@login');
//  route to create a user
Route::post('register', 'UserController@register');
// route to get user details based on user id
Route::get('user/{userId}', 'UserController@getUserDetails');

Route::group(['middleware' => 'auth:api'], function()
{
	// route to get logged in user details
   Route::post('details', 'UserController@details');
});

