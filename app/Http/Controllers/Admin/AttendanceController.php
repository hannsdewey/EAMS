<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        // Apply date filters
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->filled('day')) {
            $query->whereDay('date', $request->day);
        }

        // Filter by user if specified
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);
        $users = User::where('role', 'staff')->get();
        
        return view('admin.attendance.index', [
            'attendances' => $attendances,
            'users' => $users,
            'years' => range(date('Y') - 1, date('Y')),
            'months' => range(1, 12),
            'days' => range(1, 31),
        ]);
    }

    public function todayStatus()
    {
        $today = Carbon::today();
        
        $users = User::where('role', 'staff')->get();
        $present = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();
        $absent = $users->count() - $present;
        
        $attendances = Attendance::with('user')
            ->whereDate('date', $today)
            ->get();
            
        return view('admin.attendance.today', [
            'users' => $users,
            'present' => $present,
            'absent' => $absent,
            'attendances' => $attendances,
        ]);
    }
} 