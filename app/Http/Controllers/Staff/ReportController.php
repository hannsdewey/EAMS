<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::where('user_id', Auth::id());

        // Apply date filters
        if ($request->filled('year')) {
            $query->whereYear('report_date', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('report_date', $request->month);
        }

        $reports = $query->orderBy('report_date', 'desc')->paginate(10);
        
        // Get summary data for charts
        $summary = Report::where('user_id', Auth::id())
            ->selectRaw('
                SUM(total_present) as total_present,
                SUM(total_absent) as total_absent,
                SUM(total_late) as total_late,
                SUM(total_leave) as total_leave,
                SUM(total_work_hours) as total_work_hours,
                SUM(total_overtime_hours) as total_overtime_hours,
                SUM(active_shifts) as total_shifts
            ')
            ->first();

        return view('staff.reports.index', [
            'reports' => $reports,
            'summary' => $summary,
            'years' => range(date('Y') - 1, date('Y')),
            'months' => range(1, 12),
        ]);
    }
} 