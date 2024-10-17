<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function (Request $request) {
    $credentials = [
        'email' => 'admin22@admin.com',
        'password' => 'password'
    ];

    if (!Auth::attempt($credentials)) {
        // Create a new admin user if not authenticated
        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        // Try authenticating the newly created user
        if (Auth::attempt($credentials)) {
            $user = $request->user();

            // Create tokens and return the plain text versions
            $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete'])->plainTextToken;
            $updateToken = $user->createToken('update-token', ['create', 'update'])->plainTextToken;
            $basicToken = $user->createToken('basic-token')->plainTextToken;

            return response()->json([
                'admin' => $adminToken,
                'update' => $updateToken,
                'basic' => $basicToken
            ]);
        }
    } else {
        return response()->json(['message' => 'User already exists or authentication failed.'], 401);
    }
});
