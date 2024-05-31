<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TreatmentController;

Route::get('dashboard', fn () => view('pages.dashboard'))->name('dashboard');

Route::prefix('/treatments')
    ->name('/treatments.')
    ->controller(TreatmentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('/{treatment}/edit', 'edit')->name('edit');
        Route::match(['PUT', 'PATCH'], '{treatment}/update', 'update')->name('update');

        Route::get('datatables', 'datatables')->name('datatables');
        Route::get('{treatment}', 'show')->name('show');
        Route::delete('{treatment}', 'destroy')->name('destroy');
    });
