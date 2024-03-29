<?php

use App\Http\Controllers\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/words', [WordController::class, 'search']);