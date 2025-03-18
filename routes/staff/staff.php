<?php

use App\Http\Controllers\Staff\Account\AccountController;
use App\Http\Controllers\Staff\Infomation\InfomationController;
use App\Http\Controllers\Staff\ChangePassword\ChangePasswordController;
use App\Http\Controllers\Staff\Face\FaceController;
use App\Http\Controllers\Staff\Work\WorkController;
use App\Http\Controllers\Staff\Bonus\BonusController;
use App\Http\Controllers\Staff\Discipline\DisciplineController;
use App\Http\Controllers\Staff\Leave\LeaveRequestController;
use App\Http\Controllers\Staff\Salary\SalaryController;
use App\Http\Controllers\Staff\AttendanceController;
use App\Http\Controllers\Staff\ShiftScheduleController;
use App\Http\Controllers\Staff\ReportController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'checkuser'], function () {
    Route::prefix('account-information')->group(function () {
        Route::get('/', [InfomationController::class, 'Infomation']);
        Route::post('/edit', [InfomationController::class, 'PostEditInfomation']);
    });

    Route::prefix('change-password')->group(function () {
        Route::get('/', [ChangePasswordController::class, 'ChangePassword']);
        Route::post('/', [ChangePasswordController::class, 'PostChangePassword']);
    });

    Route::prefix('workflow-management')->group(function () {
        Route::get('/', [WorkController::class, 'ListWork']);
        Route::get('/job-details/{id}', [WorkController::class, 'WorkDetail']);
        Route::get('/update-progress/{id}', [WorkController::class, 'UpdateProgress']);
        Route::post('/update-progress/{id}', [WorkController::class, 'PostUpdateProgress']);
        Route::get('/complete-the-work/{id}', [WorkController::class, 'FinishWork']);
    });

    Route::prefix('leave-requests')->group(function () {
        Route::get('/', [LeaveRequestController::class, 'index'])->name('staff.leave-requests.index');
        Route::get('/create', [LeaveRequestController::class, 'create'])->name('staff.leave-requests.create');
        Route::post('/store', [LeaveRequestController::class, 'store'])->name('staff.leave-requests.store');
        Route::get('/{id}', [LeaveRequestController::class, 'show'])->name('staff.leave-requests.show');
    });

    Route::prefix('identity-management')->group(function () {
        Route::get('/', [FaceController::class, 'FaceStaffDetail']);
    });

    Route::prefix('bonus')->group(function () {
        Route::get('/', [BonusController::class, 'ListBonus']);;
    });
    Route::prefix('discipline')->group(function () {
        Route::get('/', [DisciplineController::class, 'ListDiscipline']);
    });
    Route::prefix('salary-management')->group(function () {
        Route::get('/', [SalaryController::class, 'ListSalary']);
    });

    Route::get('/register-faces', [FaceController::class, 'RegisterFace']);
    Route::post('/register-faces', [FaceController::class, 'PostRegisterFace']);

    Route::get('/log-out', [AccountController::class, 'Logout']);

    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('staff.attendance.index');
        Route::get('/next-action', [AttendanceController::class, 'getNextAction'])->name('staff.attendance.next-action');
    });

    Route::prefix('schedule')->group(function () {
        Route::get('/', [ShiftScheduleController::class, 'index'])->name('staff.schedule.index');
        Route::get('/events', [ShiftScheduleController::class, 'getSchedules'])->name('staff.schedule.events');
    });

    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('staff.reports.index');
    });
});
Route::get('/time-keeping', [FaceController::class, 'RecordFace']);
Route::post('/face-recognition', [FaceController::class, 'PostRecordFace']);
