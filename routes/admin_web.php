
<?php

use App\Http\Controllers\Backend\AdminUserController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->namespace('Backend')->middleware('auth:admin_users')->group(function () {
    Route::get('/','PageController@home')->name('home');
    //Backend\PageController@home ma yay chin loz namespace insert dl
    //admin.home admin.index dway yay yin kyar loz ->name('admin.') call lite dr
    //{{ route('admin.home') }} call yin d link a lote lote p

Route::resource('admin-user', 'AdminUserController');//CRUD 4 line ma yay chin loz
Route::get('admin-user/datatable/ssd','AdminUserController@ssd');

Route::resource('user', 'UserController');
Route::get('user/datatable/ssd','UserController@ssd');

Route::get('wallet','WalletController@index')->name('wallet.index');//route name->route('admin.wallet.index')
Route::get('wallet/datatable/ssd','WalletController@ssd');
});





