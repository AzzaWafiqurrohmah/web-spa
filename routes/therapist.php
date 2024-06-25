<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TreatmentController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\Therapist\PresenceController;

Route::middleware('auth')->group(function () {
    Route::get('dashboard', fn () => view('pages.dashboard'))->name('dashboard');

    Route::get('signOut', [AuthController::class, 'signOut'])->name('signOut');

    Route::prefix('/treatments')
        ->name('therapist.treatments.')
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

    Route::prefix('/customers')
        ->name('therapist.customers.')
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

    Route::prefix('/profiles')
        ->name('profiles.')
        ->controller(ProfileController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::match(['PUT', 'PATCH'], 'update', 'update')->name('update');
            Route::put('/updatePassword', 'updatePassword')->name('updatePassword');
        });

    //PRESENCE
//    Route::resource('presences', PresenceController::class);
    Route::prefix('/presences')
        ->name('presences.')
        ->controller(PresenceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('show', 'show')->name('show');
        });


    Route::get('coba', function (){
        return 'hai';
    });
});
