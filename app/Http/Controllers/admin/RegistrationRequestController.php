<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use App\Models\RegistrationRequest;
use Illuminate\Support\Facades\Hash;

class RegistrationRequestController extends Controller
{
    /**
     * Display a listing of registration requests
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $requests = RegistrationRequest::when($status !== 'all', function($query) use ($status) {
            return $query->where('status', $status);
        })
        ->with('admin')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $pendingCount = RegistrationRequest::where('status', 'pending')->count();
        $approvedCount = RegistrationRequest::where('status', 'approved')->count();
        $rejectedCount = RegistrationRequest::where('status', 'rejected')->count();

        return view('admin.registration.index', compact('requests', 'status', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Show the details of a specific registration request
     */
    public function show($id)
    {
        $request = RegistrationRequest::findOrFail($id);
        return view('admin.registration.show', compact('request'));
    }

    /**
     * Approve a registration request
     */
    public function approve(Request $request, $id)
    {
        $registrationRequest = RegistrationRequest::findOrFail($id);

        if ($registrationRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        // Create the user
        $user = User::create([
            'name' => $registrationRequest->name,
            'email' => $registrationRequest->email,
            'password' => $registrationRequest->password, // Already hashed
            'phone' => $registrationRequest->phone,
            'address' => $registrationRequest->address,
            'role' => 'User'
        ]);

        // Update registration request
        $registrationRequest->update([
            'status' => 'approved',
            'admin_id' => auth()->id(),
            'admin_note' => $request->input('admin_note'),
            'approved_at' => now()
        ]);

        // Mark related notification as read
        AdminNotification::where('registration_request_id', $id)->update(['is_read' => true]);

        return redirect()->route('registration.requests.index')->with('success', 'User account has been approved and created successfully.');
    }

    /**
     * Reject a registration request
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500'
        ]);

        $registrationRequest = RegistrationRequest::findOrFail($id);

        if ($registrationRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        $registrationRequest->update([
            'status' => 'rejected',
            'admin_id' => auth()->id(),
            'admin_note' => $request->input('admin_note')
        ]);

        // Mark related notification as read
        AdminNotification::where('registration_request_id', $id)->update(['is_read' => true]);

        return redirect()->route('registration.requests.index')->with('success', 'Registration request has been rejected.');
    }

    /**
     * Delete a registration request
     */
    public function destroy($id)
    {
        $registrationRequest = RegistrationRequest::findOrFail($id);
        $registrationRequest->delete();

        return redirect()->route('registration.requests.index')->with('success', 'Registration request deleted successfully.');
    }
}
