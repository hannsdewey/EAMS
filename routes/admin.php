<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_middleware'),
    'role:admin'
])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('admin.reports.generate');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_middleware')
])->group(function () {
    // ... existing code ...
});

require __DIR__.'/auth.php';