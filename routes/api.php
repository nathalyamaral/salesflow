<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SaleController;

Route::post('/sellers', [SellerController::class, 'store']);
Route::post('/sales', [SaleController::class, 'store']);
