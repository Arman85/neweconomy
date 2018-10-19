<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', 'SiteController@index');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function(){

	Route::get('/', 'HomeController@index');

	Route::get('admin/businesses', ['as'=> 'admin.businesses.index', 'uses' => 'Admin\BusinessController@index']);
	Route::post('admin/businesses', ['as'=> 'admin.businesses.store', 'uses' => 'Admin\BusinessController@store']);
	Route::get('admin/businesses/create', ['as'=> 'admin.businesses.create', 'uses' => 'Admin\BusinessController@create']);
	Route::put('admin/businesses/{businesses}', ['as'=> 'admin.businesses.update', 'uses' => 'Admin\BusinessController@update']);
	Route::patch('admin/businesses/{businesses}', ['as'=> 'admin.businesses.update', 'uses' => 'Admin\BusinessController@update']);
	Route::delete('admin/businesses/{businesses}', ['as'=> 'admin.businesses.destroy', 'uses' => 'Admin\BusinessController@destroy']);
	Route::get('admin/businesses/{businesses}', ['as'=> 'admin.businesses.show', 'uses' => 'Admin\BusinessController@show']);
	Route::get('admin/businesses/{businesses}/edit', ['as'=> 'admin.businesses.edit', 'uses' => 'Admin\BusinessController@edit']);
});
