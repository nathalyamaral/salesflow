<?php

use App\Jobs\SendDailySalesReport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SaleController;

Route::post('/sellers', [SellerController::class, 'store']);
Route::get('/sellers', [SellerController::class, 'index']);

Route::post('/sales', [SaleController::class, 'store']);
Route::get('/sales/{seller_id}', [SaleController::class, 'listBySeller']);

Route::post('/run-job', function () {
    dispatch(new SendDailySalesReport());
    return response()->json(['message' => 'Job run successfully!']);
});
