<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Report;
use App\Models\Attendance;
use App\Models\ShiftSchedule;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily attendance reports for all staff';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting daily report generation...');

        $today = Carbon::today();
        $users = User::role('staff')->get();
        $count = 0;

        foreach ($users as $user) {
            // Get attendance records for today
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();

            // Get active shifts for today
            $activeShifts = ShiftSchedule::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->where('status', 'active')
                ->count();

            // Get leave request for today
            $leaveRequest = LeaveRequest::where('user_id', $user->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->where('status', 'approved')
                ->first();

            // Calculate attendance status
            $isPresent = $attendance && $attendance->clock_out;
            $isLate = $attendance && $attendance->is_late;
            $isOnLeave = $leaveRequest !== null;
            $isAbsent = !$isPresent && !$isOnLeave && $activeShifts > 0;

            // Calculate work hours and overtime
            $workHours = 0;
            $overtimeHours = 0;
            if ($attendance && $attendance->clock_out) {
                $workHours = $attendance->total_work_hours;
                $overtimeHours = $attendance->total_overtime_hours;
            }

            // Create or update report
            $report = Report::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'report_date' => $today
                ],
                [
                    'total_present' => $isPresent ? 1 : 0,
                    'total_absent' => $isAbsent ? 1 : 0,
                    'total_late' => $isLate ? 1 : 0,
                    'total_leave' => $isOnLeave ? 1 : 0,
                    'total_work_hours' => $workHours,
                    'total_overtime_hours' => $overtimeHours,
                    'active_shifts' => $activeShifts
                ]
            );

            $count++;
            $this->info("Generated report for {$user->name}");
        }

        $this->info("Completed generating {$count} reports.");
    }
} 