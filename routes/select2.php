<?php

use App\Http\Controllers\Select2\TherapistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Select2\FranchiseController;

Route::get('therapists', TherapistController::class)->name('therapists');
Route::get('franchises', FranchiseController::class)->name('franchises');
