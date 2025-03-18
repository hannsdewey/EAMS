<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\Account\AccountController;

// Staff Login Routes
Route::get('/', [AccountController::class, 'Login'])->name('staff.login');
Route::post('/', [AccountController::class, 'PostLogin'])->name('staff.login.post');

// Include admin and staff routes
require __DIR__ . '/admin/admin.php';
require __DIR__ . '/staff/staff.php';

// Staff Routes
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    // ... existing code ...

    // Shift Schedule Routes
    Route::get('/schedule', [App\Http\Controllers\Staff\ShiftScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/get', [App\Http\Controllers\Staff\ShiftScheduleController::class, 'getSchedules'])->name('schedule.get');

    // ... existing code ...
});
