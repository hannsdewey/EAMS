<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('user')
            ->orderBy('date', 'asc')
            ->paginate(10);

        $users = User::where('role', 'staff')->get();

        return view('Admin.schedule.index', compact('schedules', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_start' => 'nullable',
            'break_end' => 'nullable|after:break_start',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_start' => 'nullable',
            'break_end' => 'nullable|after:break_start',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
