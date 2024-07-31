<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\TherapistController;
use App\Http\Controllers\Admin\ToolController;
use App\Http\Controllers\Admin\TreatmentCategoriesController;
use App\Http\Controllers\Admin\TreatmentController;
use App\Http\Controllers\Owner\FranchiseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Owner\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\Admin\PacketController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

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


Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/store', 'store')->name('store');
});

Route::middleware('auth')->group(function () {
    Route::get('signOut', [AuthController::class, 'signOut'])->name('signOut');

    Route::prefix('dashboard')
        ->name('dashboard.')
        ->controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/adminChart', 'adminChart')->name('adminChart');
            Route::get('/adminRanking', 'adminRanking')->name('adminRanking');
        });

    Route::prefix('customers')
        ->name('customers.')
        ->controller(CustomerController::class)->group(function () {
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
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


    //category treatment
    Route::prefix('treatmentCategories')
        ->name('treatmentCategories.')
        ->controller(TreatmentCategoriesController::class)->group(function () {
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
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
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
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
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{material}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{material}', 'show')->name('show');
            Route::delete('{material}', 'destroy')->name('destroy');
        });

    //packet treatment
    Route::prefix('packets')
        ->name('packets.')
        ->controller(PacketController::class)->group(function () {
            Route::get('/search', 'packets')->name('packets');
            Route::post('/treatmentTotal', 'treatmentTotal')->name('treatmentTotal');
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');

            Route::get('/{packet}/edit', 'edit')->name('edit');
            Route::match(['PUT', 'PATCH'], '{packet}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{packet}', 'show')->name('show');
            Route::delete('{packet}', 'destroy')->name('destroy');
        });

    //treatment
    Route::prefix('treatments')
        ->name('treatments.')
        ->controller(TreatmentController::class)->group(function () {
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('/{treatment}/edit', 'edit')->name('edit');
            Route::match(['PUT', 'PATCH'], '{treatment}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{treatment}', 'show')->name('show');
            Route::delete('{treatment}', 'destroy')->name('destroy');
        });

    //therapist
    Route::prefix('therapists')
        ->name('therapists.')
        ->controller(TherapistController::class)->group(function () {
            Route::post('/import', 'import')->name('import');
            Route::get('/export', 'export')->name('export');
            Route::get('/search', 'search')->name('search');
            Route::get('/available', 'available')->name('available');
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('/{therapist}/edit', 'edit')->name('edit');
            Route::match(['PUT', 'PATCH'], '{therapist}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{therapist}', 'show')->name('show');
            Route::delete('{therapist}', 'destroy')->name('destroy');
        });

    //treatment
    Route::prefix('reservations')
        ->name('reservations.')
        ->controller(ReservationController::class)->group(function () {
            Route::get('/cancel/{reservation}', 'cancelRsv')->name('cancel');
            Route::get('/customers', 'customers')->name('customers');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('/treatments', 'treatments')->name('treatments');
            Route::post('/treatmentTotal', 'treatmentTotal')->name('treatmentTotal');
        });

    Route::resource('reservations', ReservationController::class);
    Route::resource('setting', SettingController::class);

    //profile
    Route::prefix('/profiles')
        ->name('profiles.')
        ->controller(ProfileController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::match(['PUT', 'PATCH'], '/update', 'update')->name('update');
            Route::put('/updatePassword', 'updatePassword')->name('updatePassword');
        });

    //presence admin
    Route::prefix('presences')
        ->name('presences.')
        ->controller(PresenceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::match(['PUT', 'PATCH'], '{presence}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('presenceDatatables', 'presenceDatatables')->name('presenceDatatables');
            Route::get('{presence}', 'show')->name('show');
            Route::delete('{presence}', 'destroy')->name('destroy');
        });

    //franchise owner
    Route::prefix('franchises')
        ->name('franchises.')
        ->controller(FranchiseController::class)->group(function () {
            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('json', 'json')->name('json');
        });

    Route::resource('franchises', FranchiseController::class);

    //admin in owner
    Route::prefix('admin')
        ->name('admin.')
        ->controller(AdminController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::match(['PUT', 'PATCH'], '{user}/update', 'update')->name('update');

            Route::get('datatables', 'datatables')->name('datatables');
            Route::get('{user}', 'show')->name('show');
            Route::delete('{user}', 'destroy')->name('destroy');
        });

    Route::prefix('reports')->controller(ReportController::class)->group(function () {
        Route::get('income', 'income')->name('reports.income');
        Route::get('income/export', 'incomeExport')->name('reports.income.export');

        Route::get('outcome', 'outcome')->name('reports.outcome');
        Route::get('outcome/export', 'outcomeExport')->name('reports.outcome.export');
        Route::get('presence', 'presence')->name('reports.presence');
        Route::get('incomeOwner', 'incomeOwner')->name('reports.incomeOwner');
    });

    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('schedules/json', [ScheduleController::class, 'json'])->name('schedules.json');

    Route::prefix('regions')
        ->name('regions.')
        ->controller(RegionController::class)
        ->group(function () {
            Route::get('regencies', 'regency')->name('regencies');
            Route::get('{region:code}', 'show')->name('show');
        });
});
