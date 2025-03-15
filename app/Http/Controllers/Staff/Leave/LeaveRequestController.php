<?php

namespace App\Http\Controllers\Staff\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    // Show all leave requests of logged-in staff
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', Auth::id())->get();
        return view('Staff.Leave.index', compact('leaveRequests'));
    }

    // Show a specific leave request
    public function show($id)
    {
        $leaveRequest = LeaveRequest::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('Staff.Leave.show', compact('leaveRequest'));
    }

    // Show leave application form
    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('Staff.Leave.create', compact('leaveTypes'));
    }

    // Store a new leave request
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        LeaveRequest::create([
            'user_id' => Auth::id(),
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('staff.leave-requests.index')->with('success', 'Leave request submitted.');
    }
}
