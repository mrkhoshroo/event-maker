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

Route::group(['namespace' => 'API', 'prefix' => 'auth'], function () {
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('getuser', 'AuthController@getUser');
    });
});


Route::group(['namespace' => 'API', 'middleware' => ['auth:api']], function () {
    Route::get('users', 'UserController@index')->name('users');

    Route::get('users/{user}', 'UserController@show')->name('users.show');

    Route::get('appointments', 'AppointmentController@index')->name('appointments');

    Route::get('appointments/{appointment}', 'AppointmentController@show')->name('appointments.show');

    Route::post('appointments', 'AppointmentController@store')->name('appointments.store');

    Route::get('invitations', 'InvitationController@index')->name('invitations');

    Route::get('invitations/{appointment}', 'InvitationController@show')->name('invitations.show');

    Route::patch('invitations/{appointment}', 'InvitationController@update')->name('invitations.update');
});

