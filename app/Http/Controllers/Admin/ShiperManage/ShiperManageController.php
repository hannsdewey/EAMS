<?php

namespace App\Http\Controllers\Admin\ShiperManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ShiperManageController extends Controller
{
    public function ListShiper(Request $request, $keyword = null)
    {
        $GetShipers = DB::table('users')
            ->orderBy('users.id', 'DESC')
            ->where('users.role', '=', 4);

        if (!empty($keyword)) {
            $GetShipers = $GetShipers->where(function ($query) use ($keyword) {
                $query->where('id', 'LIKE', "%{$keyword}%")
                    ->orWhere('cmnd', 'LIKE', "%{$keyword}%")
                    ->orWhere('full_name', 'LIKE', "%{$keyword}%");
            });
        }

        $GetShipers = $GetShipers->paginate(10);

        return view('Admin.ShiperManage.ListShiper', [
            'GetShipers' => $GetShipers,
        ]);
    }

    public function BlockUnBlockAccountShiper($id)
    {
        if (!empty($id)) {
            $FindShiperById = User::find($id);

            if ($FindShiperById) {
                $FindShiperById->active = !$FindShiperById->active; // Toggle active status
                $FindShiperById->save();
                return back();
            }

            return Redirect::to('/404');
        }

        return Redirect::to('/404');
    }

    public function SearchShiper(Request $request)
    {
        if (!empty($request->keyword)) {
            $GetShipers = DB::table('users')
                ->where('users.role', '=', 4)
                ->where('users.phone', 'LIKE', "%{$request->keyword}%")
                ->orderBy('users.id', 'DESC')
                ->paginate(10);

            return view('Admin.ShiperManage.ListShiper', [
                'GetShipers' => $GetShipers,
            ]);
        }

        // Handle case where no keyword is provided
        return redirect()->back()->withErrors('Please enter a keyword to search.');
    }
}