<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'AdController@index');

Route::get('home', ['as' => 'home', 'uses' => 'AdController@index']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => ['auth']], function()
{
  Route::get('new-ad','AdController@create');

  Route::post('new-ad','AdController@store');

  Route::get('edit/{slug}','AdController@edit');

  Route::post('update','AdController@update');

  Route::get('delete/{id}','AdController@destroy');

  Route::get('my-all-ads','UserController@userAdsAll');

  Route::get('my-drafts','UserController@userAdsDraft');
});

Route::get('user/{id}','UserController@profile')->where('id', '[0-9]+');

Route::get('user/{id}/ads','UserController@userAds')->where('id', '[0-9]+');

Route::get('/{slug}',['as' => 'ad', 'uses' => 'AdController@show'])->where('slug', '[A-Za-z0-9-_]+');