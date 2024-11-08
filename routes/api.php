<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;

Route::get('/addresses/{postal_code}', [AddressController::class, 'showByPostalCode']);
