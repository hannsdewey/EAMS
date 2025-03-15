<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('user');

        // Apply date filters
        if ($request->filled('year')) {
            $query->whereYear('report_date', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('report_date', $request->month);
        }

        // Filter by user if specified
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $reports = $query->orderBy('report_date', 'desc')->paginate(10);
        $users = User::where('role', 'staff')->get();
        
        // Get summary data for charts
        $summary = Report::selectRaw('
            SUM(total_present) as total_present,
            SUM(total_absent) as total_absent,
            SUM(total_late) as total_late,
            SUM(total_leave) as total_leave,
            SUM(total_work_hours) as total_work_hours,
            SUM(total_overtime_hours) as total_overtime_hours,
            SUM(active_shifts) as total_shifts
        ');

        if ($request->filled('user_id')) {
            $summary->where('user_id', $request->user_id);
        }

        $summary = $summary->first();

        return view('admin.reports.index', [
            'reports' => $reports,
            'users' => $users,
            'summary' => $summary,
            'years' => range(date('Y') - 1, date('Y')),
            'months' => range(1, 12),
        ]);
    }

    public function generateReport()
    {
        $today = Carbon::today();
        $users = User::where('role', 'staff')->get();

        foreach ($users as $user) {
            $report = Report::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'report_date' => $today
                ],
                [
                    'total_present' => 0,
                    'total_absent' => 0,
                    'total_late' => 0,
                    'total_leave' => 0,
                    'total_work_hours' => 0,
                    'total_overtime_hours' => 0,
                    'active_shifts' => 0
                ]
            );

            // Update report data
            $attendance = $user->attendances()
                ->whereDate('date', $today)
                ->first();

            if ($attendance) {
                $report->total_present = $attendance->status == 'present' ? 1 : 0;
                $report->total_absent = $attendance->status == 'absent' ? 1 : 0;
                $report->total_late = $attendance->status == 'late' ? 1 : 0;
                $report->total_work_hours = $attendance->work_hours ?? 0;
                $report->total_overtime_hours = $attendance->overtime_hours ?? 0;
            }

            // Get active shifts
            $report->active_shifts = $user->shiftSchedules()
                ->whereDate('date', $today)
                ->where('status', 'active')
                ->count();

            // Get leave requests
            $report->total_leave = $user->leaveRequests()
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->where('status', 'approved')
                ->count();

            $report->save();
        }

        return response()->json(['message' => 'Reports generated successfully']);
    }
} 