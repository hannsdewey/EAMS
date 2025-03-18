<?php

namespace App\Http\Controllers\Staff\Face;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ShiftSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;

class FaceController extends Controller
{
    public function FaceStaffDetail()
    {
        $getImages = DB::table('user_face')->where('user_id', Auth::user()->id)->get();
        return view(
            'Staff.Face.FaceStaffDetail',
            [
                'getImages' => $getImages,
            ]
        );
    }



    public function ConfirmFace()
    {
        Session::put('confirm_face', 'ok');
        return redirect(url('kenh-giao-hang/account-information'));
    }
    public function RegisterFace()
    {
        $checkHaveFace = DB::table('user_face')->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();
        if ($checkHaveFace == null) {
            return view('Staff.RegisterFace.Index');
        } else {
            return redirect('account-information');
        }
    }

    public function PostRegisterFace(Request $request)
    {
        $getMax = DB::table('user_face')->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();

        $getFullName = DB::table('user_infomations')->where('user_id', Auth::user()->id)->first('full_name');
        if ($getMax == null) {
            $getMax = 1;
        } else {
            $getMax = $getMax->order_by + 1;
        }
        $image_64 = $request->image;
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
        $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = $getMax . '.jpg';
        Storage::put('public/face-data/' . $getFullName->full_name . '/' . $imageName, base64_decode($image));

        DB::table('user_face')->insert(['image' => $imageName, 'name' => $getFullName->full_name, 'order_by' => $getMax, 'created_at' => time(), 'user_id' => Auth::user()->id]);
    }



    public function RecordFace()
    {
        Session::put('first_name', "ok");
        $getUsers = DB::table('users')
            ->leftJoin('user_face', 'user_face.user_id', 'users.id')
            ->where('users.role', 2)
            ->where('users.is_deleted', 0)
            ->select('user_face.name')
            ->where('user_face.name', '!=', null)
            ->groupBy('user_face.name')
            ->get();

        return view('Staff.CheckFace.Index', ['getUsers' => $getUsers]);
    }

    public function PostRecordFace(Request $request)
    {
        $getUser = DB::table('user_infomations')->where('full_name', $request->name)->first('user_id');
        if (!$getUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $today = Carbon::today();
        $now = Carbon::now();

        // Check if user has schedule for today
        $schedule = ShiftSchedule::where('user_id', $getUser->user_id)
            ->whereDate('date', $today)
            ->where('status', 'active')
            ->first();

        if (!$schedule) {
            return response()->json(['error' => 'No schedule found for today'], 403);
        }

        // Get or create today's attendance record
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $getUser->user_id,
                'date' => $today
            ],
            [
                'status' => 'present',
                'work_hours' => 0,
                'overtime_hours' => 0
            ]
        );

        // Determine next action based on current state
        if (!$attendance->clock_in) {
            $attendance->clock_in = $now;
            $attendance->status = $now->gt(Carbon::parse($schedule->shift_start)) ? 'late' : 'present';
        } elseif (!$attendance->break_in && !$attendance->break_out) {
            $attendance->break_in = $now;
        } elseif ($attendance->break_in && !$attendance->break_out) {
            $attendance->break_out = $now;
        } elseif (!$attendance->clock_out) {
            $attendance->clock_out = $now;

            // Calculate work hours
            $totalMinutes = $now->diffInMinutes(Carbon::parse($attendance->clock_in));
            if ($attendance->break_in && $attendance->break_out) {
                $breakMinutes = Carbon::parse($attendance->break_out)
                    ->diffInMinutes(Carbon::parse($attendance->break_in));
                $totalMinutes -= $breakMinutes;
            }

            $attendance->work_hours = round($totalMinutes / 60, 2);

            // Calculate overtime if applicable
            $scheduledEnd = Carbon::parse($schedule->shift_end);
            if ($now->gt($scheduledEnd)) {
                $overtimeMinutes = $now->diffInMinutes($scheduledEnd);
                $attendance->overtime_hours = round($overtimeMinutes / 60, 2);
            }
        }

        $attendance->save();

        // Determine message based on action taken
        if ($attendance->clock_in && !$attendance->break_in) {
            $message = $request->name . " - Clocked in at " . $attendance->clock_in->format('H:i:s');
        } elseif ($attendance->break_in && !$attendance->break_out) {
            $message = $request->name . " - Break started at " . $attendance->break_in->format('H:i:s');
        } elseif ($attendance->break_out && !$attendance->clock_out) {
            $message = $request->name . " - Break ended at " . $attendance->break_out->format('H:i:s');
        } elseif ($attendance->clock_out) {
            $message = $request->name . " - Clocked out at " . $attendance->clock_out->format('H:i:s');
        }

        return response()->json(['message' => $message]);
    }
}
