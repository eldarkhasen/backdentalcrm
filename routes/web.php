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

Route::group(['namespace' => 'Web'], function () {
    Route::get('/', ['uses' => 'MainController@index']);
    Route::get('/secure/config', ['uses' => 'ConfigController@configure']);
    Route::group(['namespace' => 'Auth'], function () {

        Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
        Route::post('password/email', ['as' => 'password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
        Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'ResetPasswordController@showResetForm']);
        Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'ResetPasswordController@reset']);

        Route::group(['middleware' => 'guest'], function () {
            Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
            Route::post('login', ['as' => 'login.post', 'uses' => 'LoginController@login']);
        });
        Route::group(['middleware' => 'auth'], function () {
            Route::post('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
        });
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);
//        Route::apiResource('/organizations', 'OrganizationController')
//            ->name('index', 'organizations');
        Route::resource('organizations', 'OrganizationController');
        Route::resource('subscriptiontypes', 'SubscriptionTypeController');
        Route::post('addSubscription', 'OrganizationController@addSubscription');
        Route::post('addEmployee', 'OrganizationController@addEmployee');
        Route::post('addInspectionOption', 'InitialInspectionTypeController@addOption');
        Route::get('editInspectionOption/{id}', ['uses'=>'InitialInspectionTypeController@editOption', 'as'=>'inspectionOptions.edit']);
        Route::patch('updateInspectionOption/{id}', ['uses'=>'InitialInspectionTypeController@updateOption', 'as'=>'inspectionOptions.update']);
        Route::delete('destroyInspectionOption/{id}', ['uses'=>'InitialInspectionTypeController@destroyOption', 'as'=>'inspectionOptions.destroy']);
        Route::get('owners', ['uses' => 'OwnerController@index', 'as' => 'owner.index']);

//        Route::get('initialInspectionType', ['uses' => 'InitialInspectionTypeController@index', 'as' => 'initInspectionType.index']);
////        Route::get('initialInspectionType/{id}', ['uses' => 'InitialInspectionTypeController@show', 'as' => 'initInspectionType.show']);
////        Route::get('initialInspectionType/{id}', ['uses' => 'InitialInspectionTypeController@show', 'as' => 'initInspectionType.show']);
////        Route::post('addInitInspectionType', ['uses' => 'InitialInspectionTypeController@store']);
        Route::resource('initialInspectionTypes', 'InitialInspectionTypeController');

        Route::group(['prefix'=> 'treatment', 'as' => 'treatment.'] , function (){
            Route::resource('template', 'TreatmentTemplatesController');
        });

        Route::get('/apidoc', ['uses' => 'ConfigController@apiDoc']);
    });
});


