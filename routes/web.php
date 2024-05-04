<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Owner\FranchiseController;
use App\Http\Controllers\TreatmentCategoriesController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TreatmentController;
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

            Route::get('/{customer}/edit', 'edit')->name('edit');
            Route::match(['PUT', 'PATCH'], '{customer}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{customer}', 'show')->name('show');

            Route::delete('{customer}', 'destroy')->name('destroy');
            Route::post('{id}/member', 'member')->name('member');
            Route::post('{month}/birthdate', 'birthdate')->name('birthdate');
        });

    //franchise owner
    Route::resource('franchises', FranchiseController::class);

    //category treatment
    Route::prefix('treatmentCategories')
        ->name('treatmentCategories.')
        ->controller(TreatmentCategoriesController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{treatmentCategory}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{treatmentCategory}', 'show')->name('show');

            Route::delete('{treatmentCategory}', 'destroy')->name('destroy');
        });

    //tool treatment
    Route::prefix('tools')
        ->name('tools.')
        ->controller(ToolController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{tool}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{tool}', 'show')->name('show');

            Route::delete('{tool}', 'destroy')->name('destroy');
        });

    //material treatment
    Route::prefix('materials')
        ->name('materials.')
        ->controller(MaterialController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{material}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{material}', 'show')->name('show');
            Route::delete('{material}', 'destroy')->name('destroy');
        });

    //treatment
    Route::prefix('treatments')
        ->name('treatments.')
        ->controller(TreatmentController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{treatment}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{treatment}', 'show')->name('show');
            Route::delete('{treatment}', 'destroy')->name('destroy');
        });

});
