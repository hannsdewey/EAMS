Route::middleware(['auth', 'role:staff'])->group(function () {
    // ... existing code ...
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Staff\ReportController::class, 'index'])->name('staff.reports.index');
}); 