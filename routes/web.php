<?php
use Ivory\GoogleMap;
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

//Auth::routes();

Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');
Route::group(['middleware' => 'AuthUser', 'prefix' => 'user'], function () {
Route::get('/home', 'HomeController@index')->name('home');
});


Route::group(['middleware' => 'AuthAdmin', 'prefix' => 'admin'], function () {
    Route::resource('authors', 'AuthorsController');
    Route::resource('books', 'BooksController');
    Route::get('/home', 'HomeController@indexAdmin');
    Route::get('/adminlte', 'adminLte@adminLte');
});
Route::delete('authors/mass_destroy', 'AuthorsController@massDestroy')->name('authors.mass_destroy');
Route::resource('authors', 'AuthorsController');

Route::get('/map','IndexController@index');
Route::get('/multimap',function(){
  return view('multi_direction');
});
Route::get('/dir_map',function(){
  return view('single_direction');
});
