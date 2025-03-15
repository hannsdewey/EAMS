<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class LeaveRequestController extends Controller
{
    // Display all leave requests
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())->get();
        return view('Staff.Leave.index', compact('leaveRequests'));
    }

    // Show a single leave request
    public function show($id)
    {
        $leaveRequest = LeaveRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('Staff.Leave.show', compact('leaveRequest'));
    }

    // Approve a leave request
    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'approved']);

        return redirect()->route('admin.leave.index')->with('success', 'Leave request approved.');
    }

    // Reject a leave request
    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);

        return redirect()->route('admin.leave.index')->with('error', 'Leave request rejected.');
    }
}