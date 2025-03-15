<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiftSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftScheduleController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.schedule.index', compact('users'));
    }

    public function getSchedules(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $query = ShiftSchedule::with('user')
            ->whereBetween('date', [$start, $end])
            ->where('status', 'active');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $schedules = $query->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->user->name . ' - Shift: ' . 
                          Carbon::parse($schedule->shift_start)->format('H:i') . 
                          ' - ' . Carbon::parse($schedule->shift_end)->format('H:i'),
                'start' => $schedule->date . 'T' . $schedule->shift_start,
                'end' => $schedule->date . 'T' . $schedule->shift_end,
                'user_id' => $schedule->user_id,
            ];
        });

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'shift_start' => 'required',
            'shift_end' => 'required|after:shift_start',
            'break_start' => 'nullable',
            'break_end' => 'nullable|after:break_start',
        ]);

        ShiftSchedule::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        return response()->json(['message' => 'Schedule created successfully']);
    }

    public function update(Request $request, ShiftSchedule $schedule)
    {
        $request->validate([
            'shift_start' => 'required',
            'shift_end' => 'required|after:shift_start',
            'break_start' => 'nullable',
            'break_end' => 'nullable|after:break_start',
        ]);

        $schedule->update([
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
        ]);

        return response()->json(['message' => 'Schedule updated successfully']);
    }

    public function destroy(ShiftSchedule $schedule)
    {
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
} 