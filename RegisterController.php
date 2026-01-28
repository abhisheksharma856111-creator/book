<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Handle user registration via AJAX
     */
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'password'        => 'required|string|min:8|confirmed',
            'house_street'    => 'required|string|max:255',
            'landmark'        => 'nullable|string|max:255',
            'city'            => 'required|string|max:100',
            'state'           => 'required|string|max:100',
            'zip_code'        => 'required|string|max:20',
            'country'         => 'required|string|max:100',
            'full_address'    => 'required|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Handle profile picture upload
        $profilePath = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profiles', $filename, 'public');
            $profilePath = 'storage/' . $path;
        }

        // Create new user
        $user = User::create([
            'name'            => $request->full_name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'house_street'    => $request->house_street,
            'landmark'        => $request->landmark,
            'city'            => $request->city,
            'state'           => $request->state,
            'zip_code'        => $request->zip_code,
            'country'         => $request->country,
            'full_address'    => $request->full_address,
            'profile_picture' => $profilePath,
            'role'            => 'user', // default role
        ]);

        // You can auto-login here if you want:
        // Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! You can now login.'
        ]);
    }
}