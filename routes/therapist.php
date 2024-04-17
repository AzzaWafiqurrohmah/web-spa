<?php

use Illuminate\Support\Facades\Route;

Route::get('dashboard', fn () => view('pages.dashboard'))->name('dashboard');
