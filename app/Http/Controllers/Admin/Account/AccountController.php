<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
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
        return Redirect::to('/');
    }

    public function Login()
    {
        if (Auth::user()) {
            return Redirect::to('/');
        } else {
            return view('Admin.Login.Index');
        }
    }
    public function LoginPost(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            if ($user->role == 1) {
                return Redirect::to('/admin/user-management');
            } else {
                Auth::logout();
                return redirect()->back()->with('msg', 'Unauthorized access.');
            }
        } else {
            return redirect()->back()->with('msg', 'Wrong account or password');
        }
    }
}
