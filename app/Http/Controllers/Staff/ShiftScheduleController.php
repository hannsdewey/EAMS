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
        return view('Staff.Schedule.index');
    }

    public function getSchedules(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $schedules = ShiftSchedule::where('user_id', Auth::id())
            ->where('status', 'active')
            ->whereBetween('date', [$start, $end])
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => 'Shift: ' . Carbon::parse($schedule->shift_start)->format('H:i') . ' - ' .
                        Carbon::parse($schedule->shift_end)->format('H:i'),
                    'start' => $schedule->date->format('Y-m-d'),
                    'end' => $schedule->date->format('Y-m-d'),
                    'backgroundColor' => '#3c8dbc',
                    'borderColor' => '#3c8dbc',
                    'break_start' => $schedule->break_start,
                    'break_end' => $schedule->break_end,
                    'allDay' => true
                ];
            });

        return response()->json($schedules);
    }
}
