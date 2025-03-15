<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftScheduleController extends Controller
{
    public function index()
    {
        return view('staff.schedule.index');
    }

    public function getSchedules(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $schedules = ShiftSchedule::where('user_id', Auth::id())
            ->whereBetween('date', [$start, $end])
            ->where('status', 'active')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => 'Shift: ' . Carbon::parse($schedule->shift_start)->format('H:i') . 
                              ' - ' . Carbon::parse($schedule->shift_end)->format('H:i'),
                    'start' => $schedule->date . 'T' . $schedule->shift_start,
                    'end' => $schedule->date . 'T' . $schedule->shift_end,
                    'break_start' => $schedule->break_start ? 
                        $schedule->date . 'T' . $schedule->break_start : null,
                    'break_end' => $schedule->break_end ? 
                        $schedule->date . 'T' . $schedule->break_end : null,
                ];
            });

        return response()->json($schedules);
    }
} 