<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SaleController;

Route::post('/sellers', [SellerController::class, 'store']);
Route::get('/sellers', [SellerController::class, 'index']);

Route::post('/sales', [SaleController::class, 'store']);
Route::get('/sales/{seller_id}', [SaleController::class, 'listBySeller']);
