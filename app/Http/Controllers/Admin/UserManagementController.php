<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function create(Request $request)
    {
        try {
            Log::info('User creation request:', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:6',
                'department_id' => 'required|exists:departments,id',
                'position_id' => 'required|exists:positions,id',
                'role' => 'required|in:1,2,3'
            ]);

            // Generate a default email if not provided
            $email = $request->email ?? strtolower(str_replace(' ', '.', $request->name)) . '@example.com';

            $userData = [
                'name' => $request->name,
                'email' => $email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'role' => $request->role,
                'active' => 1,
                'created_at' => now()
            ];

            Log::info('Creating user with data:', $userData);

            $userId = DB::table('users')->insertGetId($userData);

            return response()->json(['success' => true, 'message' => 'User created successfully']);
        } catch (\Exception $e) {
            Log::error('User creation error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
