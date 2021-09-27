<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\CssSelector\Node\FunctionNode;

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

//admin user auth
Route::get('/admin/login','Auth\AdminLoginController@showLoginForm');
Route::post('/admin/login','Auth\AdminLoginController@Login')->name('admin.login');
//d controller mar login method ma shi buu //but AuthiticataedUsers ka Login ko callc dr
Route::post('/admin/logout','Auth\AdminLoginController@logout')->name('admin.logout');



//normal user auth
Auth::routes();
Route::middleware('auth')->namespace('Frontend')->group(function(){//to login
    Route::get("/","PageController@home")->name("home");

    Route::get("/profile","PageController@profile")->name("profile");

    Route::get('/update-password','PageController@updatePassword')->name('update-password');
    Route::post('/update-password','PageController@storeUpdatePassword')->name('update-password.store');

    Route::get('/wallet','PageController@showWallet')->name('wallet');

    Route::get('/transfer','PageController@showTransfer')->name('transfer');
    Route::post('/transfer/confirm','PageController@transferConfirm');
    Route::post('/transfer/complete','PageController@transferComplete');

    Route::get('/transfer/confirm/password','PageController@checkPassword');
    Route::get('/to-account-verify','PageController@accountVerify');

    Route::get('/transaction','PageController@transaction');
    Route::get('/transaction/detail/{id}','PageController@transactionDetail');
});




