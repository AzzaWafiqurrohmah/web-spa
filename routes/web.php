<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/store', 'store')->name('store');
});

Route::middleware('auth')->group(function () {
    //dashboard
    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::prefix('customers')
        ->name('customers.')
        ->controller(CustomerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{customer}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{customer}', 'show')->name('show');

            Route::delete('{customer}', 'destroy')->name('destroy');
        });
});
