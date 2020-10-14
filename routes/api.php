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

// // Route::post('/test','TestController@test');
Route::group(['prefix'=>'{version}'], function(){
    
    $version = app('request')->segment(2);

    Route::post('/test', [ controller('TestsController',$version) , 'test']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
