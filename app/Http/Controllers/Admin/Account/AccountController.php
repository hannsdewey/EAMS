<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB;

class AccountController extends Controller
{
    public function Logout()
    {
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
        return Redirect::to('/admin/login');
    }

    public function Login()
    {
        if (Auth::check()) {
            return Redirect::to('/admin/user-management');
        }
        return view('Admin.Login.Index');
    }

    public function LoginPost(Request $request)
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

            if ($user->role != 1) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'You do not have permission to access the admin area.'])
                    ->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return Redirect::to('/admin/user-management');
        }

        return redirect()->back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->withInput($request->except('password'));
    }
}
