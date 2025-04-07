<?php

use Illuminate\Support\Facades\Route;

Route::prefix('transfer')->group(base_path('routes/transfer.php'));
Route::prefix('user')->group(base_path('routes/user.php'));
Route::prefix('account')->group(base_path('routes/account.php'));
