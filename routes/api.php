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

Route::namespace("Api")->group(function() {
    Route::post('/send-otp', 'AuthController@sendOTP');
    Route::post('/verify-otp', 'AuthController@verifyOTP');
    Route::post('/register', 'UserController@userRegister');
    Route::get('/user-profile', 'UserController@userProfile');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
