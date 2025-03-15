<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with('user', 'leaveType')->orderBy('status')->get();
        return view('admin.leave.index', compact('leaveRequests'));
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        return view('admin.leave.edit', compact('leaveRequest'));
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $leaveRequest->update(['status' => $request->status]);
        return redirect()->route('leaves.index')->with('success', 'Leave request updated.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }
}
