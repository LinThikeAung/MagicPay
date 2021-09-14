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

//normal user auth
Auth::routes();

//admin user auth
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm');
Route::post('/admin/login','Auth\AdminLoginController@Login')->name('admin.login');
//d controller mar login method ma shi buu //but AuthiticataedUsers ka Login ko callc dr
Route::post('/admin/logout','Auth\AdminLoginController@logout')->name('admin.logout');


Route::get('/',"Frontend\PageController@home");



