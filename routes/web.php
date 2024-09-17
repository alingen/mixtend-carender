<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;

Route::get('/meetings', [MeetingController::class, 'index']);
