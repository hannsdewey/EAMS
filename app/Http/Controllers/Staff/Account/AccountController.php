<?php

namespace App\Http\Controllers\Staff\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use DB;


class AccountController extends Controller
{
    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }
    public function Login()
    {
        return view('Staff.Account.Login');
    }
    public function PostLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role != 2) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'You do not have permission to access the staff area.'])
                    ->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect()->route('staff.attendance.index');
        }

        return redirect()->back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->withInput($request->except('password'));
    }
}
