<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TreatmentController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\Therapist\PresenceController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')
        ->name('dashboard.')
        ->controller(DashboardController::class)->group(function (){
            Route::get('/', 'index')->name('index');
            Route::get('/adminChart', 'adminChart')->name('adminChart');
            Route::get('/adminRanking', 'adminRanking')->name('adminRanking');
        });

    Route::get('signOut', [AuthController::class, 'signOut'])->name('signOut');

    Route::prefix('/treatments')
        ->name('treatments.')
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

    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/json', [ScheduleController::class, 'json'])->name('schedules.json');

    Route::prefix('reservations')
        ->name('reservations.')
        ->controller(ReservationController::class)->group(function () {
            Route::get('/customers', 'customers')->name('customers');
            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('/treatments', 'treatments')->name('treatments');
            Route::post('/treatmentTotal', 'treatmentTotal')->name('treatmentTotal');
        });

    Route::resource('reservations', ReservationController::class);

});
