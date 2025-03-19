<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('Admin.attendance.index', compact('attendances'));
    }

    public function todayStatus()
    {
        $today = Carbon::today();
        $attendances = Attendance::with('user')
            ->whereDate('date', $today)
            ->get();

        return view('Admin.attendance.today', compact('attendances'));
    }
}
