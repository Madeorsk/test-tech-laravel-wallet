<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendMoneyController;
use App\Http\Controllers\SetRecurringTransferController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/send-money', [SendMoneyController::class, '__invoke'])->name('send-money');
    Route::post('/set-recurring-transfers', [SetRecurringTransferController::class, '__invoke'])->name('set-recurring-transfers');
});

require __DIR__.'/auth.php';
