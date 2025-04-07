<?php

use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::post('', [TransferController::class, 'transfer'])->name('transfer');
