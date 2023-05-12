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

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/', 'Controller@index')->name('indexView');
Route::post('/reservation', 'ReservationController@reserve')->name('reservation.reserve');
Route::post('/contact', 'ContactController@sendMessage')->name('contact.send');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::resource('slider', 'SliderController');
    Route::resource('category', 'CategoryController');
    Route::resource('item', 'ItemController');
    Route::get('reservation', 'ReservationController@index')->name('reservation.index');
    Route::post('reservation/{id}', 'ReservationController@status')->name('reservation.status');
    Route::delete('reservation/{id}', 'ReservationController@destroy')->name('reservation.destroy');

    Route::get('room', [RoomController::class, 'index'])->name('room.index');
    Route::get('room/{id}', [RoomController::class, 'show'])->name('room.show');
    Route::get('room/create/new', [RoomController::class, 'create'])->name('room.create');
    Route::post('room/create', [RoomController::class, 'store'])->name('room.store');


    Route::get('place/{id}', [PlaceController::class, 'show'])->name('place.show');
    Route::get('place/{id}/receipt', [OrderController::class, 'receiptShow'])->name('receipt.show');
    Route::get('place/create/new', [PlaceController::class, 'create'])->name('place.create');
    Route::post('place/create', [PlaceController::class, 'store'])->name('place.store');

    Route::get('contact', 'ContactController@index')->name('contact.index');
    Route::get('contact/{id}', 'ContactController@show')->name('contact.show');
    Route::delete('contact/{id}', 'ContactController@destroy')->name('contact.destroy');


    Route::get('allitems', [ItemController::class, 'getItems'])->name('getItems');
    Route::get('allcategories', [CategoryController::class, 'getCategories'])->name('getCategories');
    Route::post('addorder', [OrderController::class, 'addOrder'])->name('addOrder');
    Route::post('calculatePrice', [OrderController::class, 'calculatePrice'])->name('calculatePrice');
});
