<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('transactions')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('{uuid}', 'show');
});
