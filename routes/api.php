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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


Route::group(['prefix' => 'targets'], function () {
    Route::get('/{targetId}', 'Api\TargetsController@show');
});

Route::post('users', 'Api\UsersController@info')->middleware('auth:api');

Route::get('creations', 'Api\DesignsController@creations')->middleware('auth:api');
//Route::get('resources', 'Api\DesignsController@resources')->middleware('auth:api');

Route::resource('resources','Api\ResourceController');
Route::post('resourcesAndre/{id}','Api\ResourceController@updateP');

//Route::post('images', 'Api\DesignsController@images')->middleware('auth:api');
//Route::put('images', 'Api\DesignsController@update')->middleware('auth:api');