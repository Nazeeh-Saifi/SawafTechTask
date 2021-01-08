<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products',ProductController::class);
Route::apiResource('suppliers',SupplierController::class);

/* 
Route::prefix('menu/menu')->group(function () { 
    Route::get('/',         'MenuEditController@index')->name('menu.menu.index');
    Route::get('/create',   'MenuEditController@create')->name('menu.menu.create');
    Route::post('/store',   'MenuEditController@store')->name('menu.menu.store');
    Route::get('/edit',     'MenuEditController@edit')->name('menu.menu.edit');
    Route::post('/update',  'MenuEditController@update')->name('menu.menu.update');
    Route::get('/delete',   'MenuEditController@delete')->name('menu.menu.delete');
});
 */