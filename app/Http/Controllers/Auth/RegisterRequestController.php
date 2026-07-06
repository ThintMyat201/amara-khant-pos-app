<?php

namespace App\Http\Controllers\Auth;

use App\Models\AdminNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterRequestController extends Controller
{
    /**
     * Show the registration request form
     */
    public function create()
    {
        return view('auth.register-request');
    }

    /**
     * Handle the registration request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:registration_requests',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create registration request
        $registrationRequest = RegistrationRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'pending'
        ]);

        // Create notification for admin
        AdminNotification::create([
            'type' => 'registration_request',
            'message' => "New registration request from {$request->name} ({$request->email})",
            'registration_request_id' => $registrationRequest->id,
            'is_read' => false
        ]);

        return redirect()->route('login')->with('success', 'Your registration request has been submitted. Please wait for admin approval.');
    }
}
