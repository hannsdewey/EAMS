<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    // Display all leave requests
    public function index()
    {
        $leaveRequests = LeaveRequest::with(['user', 'leaveType', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Admin.Leave.index', compact('leaveRequests'));
    }

    // Show a single leave request
    public function show($id)
    {
        $leaveRequest = LeaveRequest::with(['user', 'leaveType', 'approvedBy'])
            ->findOrFail($id);
        return view('Admin.Leave.show', compact('leaveRequest'));
    }

    // Approve a leave request
    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        // Update leave request status
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => Carbon::now()
        ]);

        // Create attendance records for the leave period
        $startDate = Carbon::parse($leaveRequest->start_date);
        $endDate = Carbon::parse($leaveRequest->end_date);

        while ($startDate <= $endDate) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $leaveRequest->user_id,
                    'date' => $startDate->format('Y-m-d')
                ],
                [
                    'status' => 'leave',
                    'work_hours' => 0,
                    'overtime_hours' => 0
                ]
            );
            $startDate->addDay();
        }

        return redirect()->route('admin.leave.index')
            ->with('success', 'Leave request approved successfully.');
    }

    // Reject a leave request
    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => Carbon::now()
        ]);

        return redirect()->route('admin.leave.index')
            ->with('error', 'Leave request rejected.');
    }
}
