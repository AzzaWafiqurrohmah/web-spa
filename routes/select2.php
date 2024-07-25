<?php

use App\Http\Controllers\Select2\TherapistController;
use Illuminate\Support\Facades\Route;

Route::get('therapists', TherapistController::class)->name('therapists');
