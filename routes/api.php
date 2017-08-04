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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->group(function () {
    Route::get('templates', 'TemplatesController@index');
    Route::get('templates/{id}', 'TemplatesController@show');
    Route::post('templates', 'TemplatesController@store');
    Route::put('templates/{id}', 'TemplatesController@activate');

    Route::put('template-pages/{id}', 'TemplatePagesController@update');

    Route::post('widget', 'WidgetController@generate');
});
