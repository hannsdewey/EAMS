<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::where('user_id', Auth::id());

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

        $attendances = $query->orderBy('date', 'desc')->paginate(10);
        
        return view('staff.attendance.index', [
            'attendances' => $attendances,
            'years' => range(date('Y') - 1, date('Y')),
            'months' => range(1, 12),
            'days' => range(1, 31),
        ]);
    }

    public function getNextAction()
    {
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            // Check if user has schedule for today
            $schedule = ShiftSchedule::where('user_id', Auth::id())
                ->whereDate('date', $today)
                ->where('status', 'active')
                ->first();

            if (!$schedule) {
                return response()->json(['message' => 'No schedule found for today', 'next_action' => null]);
            }

            return response()->json(['next_action' => 'clock_in']);
        }

        if (!$attendance->clock_in) {
            return response()->json(['next_action' => 'clock_in']);
        }

        if (!$attendance->break_in && !$attendance->break_out) {
            return response()->json(['next_action' => 'break_in']);
        }

        if ($attendance->break_in && !$attendance->break_out) {
            return response()->json(['next_action' => 'break_out']);
        }

        if (!$attendance->clock_out) {
            return response()->json(['next_action' => 'clock_out']);
        }

        return response()->json(['next_action' => null]);
    }
} 