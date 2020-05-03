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

/*Route::get('/', function () {
    //return view('welcome');
    $user = \App\User::first();
    $roles =  \App\Role::all();

    $user->roles()->attach($roles);

    dd($roles);


});*/
Auth::routes();
Route::get('/',"TestController@index");
Route::get('/insert',"TestController@insert");
Route::get('/update',"TestController@update");
Route::get('/delete/{id}',"TestController@delete");

Route::get('/relation',"TestController@getPivotData");

/*Route::get('/getPhone',"TestController@index");*/

//Route::get('/getPosts',"TestController@posts");

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');


Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');


Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin');


//Route::group(['middleware' => ['auth.user']], function () {
//    // login protected routes.
//});
//
//Route::group(['middleware' => ['auth.admin']], function () {
//    // login protected routes.
//});






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
