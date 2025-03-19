<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // Get schedules for the selected month
        $schedules = Schedule::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        // Generate array of years (current year and 2 years before)
        $currentYear = now()->year;
        $years = range($currentYear - 2, $currentYear);

        // Generate array of months
        $months = range(1, 12);

        return view('Staff.schedule.index', compact('schedules', 'year', 'month', 'years', 'months'));
    }
}
