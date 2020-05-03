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
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', ['uses' => 'AuthController@authFail', 'as' => 'login']);
    Route::post('/login','AuthController@authenticate');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('/me', ['uses' => 'AuthController@me']);
    });

    Route::group(['namespace' => 'Management'], function () {
        Route::get('/roles','RolesController@index');
        Route::get('/permissions','PermissionsController@getAllPermissions');
    });
    Route::group(['namespace' => 'Settings'], function () {
        Route::get('/services','ServicesController@index');
        Route::get('/services_by_category/{id}','ServicesController@getAllServicesByCategory')->where('category_id', '[0-9]+');
        Route::get('/service_categories','ServicesController@getServiceCategories');
        Route::get('/search_services','ServicesController@searchServices');
        Route::get('/services/{id}','ServicesController@getServiceById');

        Route::post('/services','ServicesController@store');
        Route::put('/services/{id}','ServicesController@update');

        Route::post('/service_categories','ServicesController@storeCategory');
        Route::put('/service_categories/{id}','ServicesController@updateCategory');
    });
});
