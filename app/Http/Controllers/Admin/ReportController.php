<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'staff');

        // Apply filters
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }
        if ($request->filled('position')) {
            $query->where('position_id', $request->position);
        }

        $users = $query->get();

        // Get attendance summary
        $attendanceSummary = Attendance::selectRaw('
            COUNT(*) as total_days,
            SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days,
            SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_days,
            SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_days
        ')->first();

        // Get leave summary
        $leaveSummary = Leave::selectRaw('
            COUNT(*) as total_requests,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_requests,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_requests,
            SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_requests
        ')->first();

        return view('Admin.reports.index', compact('users', 'attendanceSummary', 'leaveSummary'));
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