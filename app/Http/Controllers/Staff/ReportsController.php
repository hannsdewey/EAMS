<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\ShiftSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Get attendance data
        $attendances = Attendance::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        // Get leave requests
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
            })
            ->get();

        // Get shift schedules
        $schedules = ShiftSchedule::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'active')
            ->get();

        // Calculate summary statistics
        $summary = [
            'total_present' => $attendances->where('status', 'present')->count(),
            'total_absent' => $attendances->where('status', 'absent')->count(),
            'total_late' => $attendances->where('status', 'late')->count(),
            'total_leave' => $leaveRequests->count(),
            'total_work_hours' => $attendances->sum('work_hours'),
            'total_overtime_hours' => $attendances->sum('overtime_hours'),
            'active_shifts' => $schedules->count()
        ];

        // Generate daily reports
        $reports = collect();
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $attendance = $attendances->firstWhere('date', $currentDate->format('Y-m-d'));
            $leave = $leaveRequests->filter(function ($request) use ($currentDate) {
                return $currentDate->between($request->start_date, $request->end_date);
            })->first();
            $schedule = $schedules->firstWhere('date', $currentDate->format('Y-m-d'));

            $reports->push([
                'report_date' => $currentDate->copy(),
                'total_present' => $attendance && $attendance->status === 'present' ? 1 : 0,
                'total_absent' => $attendance && $attendance->status === 'absent' ? 1 : 0,
                'total_late' => $attendance && $attendance->status === 'late' ? 1 : 0,
                'total_leave' => $leave ? 1 : 0,
                'total_work_hours' => $attendance ? $attendance->work_hours : 0,
                'total_overtime_hours' => $attendance ? $attendance->overtime_hours : 0,
                'active_shifts' => $schedule ? 1 : 0
            ]);

            $currentDate->addDay();
        }

        $years = range(date('Y') - 1, date('Y'));
        $months = range(1, 12);

        return view('Staff.Reports.index', compact(
            'reports',
            'summary',
            'year',
            'month',
            'years',
            'months'
        ));
    }
}
