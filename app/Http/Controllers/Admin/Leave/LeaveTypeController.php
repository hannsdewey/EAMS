<?php

namespace App\Http\Controllers\Admin\Leave;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    // Display the list of leave types
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.leave_types.index', compact('leaveTypes'));
    }

    // Show the form for creating a new leave type
    public function create()
    {
        return view('admin.leave_types.create');
    }

    // Store a new leave type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:leave_types',
            'description' => 'nullable'
        ]);

        LeaveType::create($request->all());

        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type added.');
    }

    // Show the form for editing an existing leave type
    public function edit(LeaveType $leaveType)
    {
        return view('admin.leave_types.edit', compact('leaveType'));
    }


    // Update an existing leave type
    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $leaveType->update($request->all());

        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type updated.');
    }


    // Delete a leave type
    public function destroy(LeaveType $leaveType)
    {
        $leaveType->delete();
        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type deleted.');
    }
}
