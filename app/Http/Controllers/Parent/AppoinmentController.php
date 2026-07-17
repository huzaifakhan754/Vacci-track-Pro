<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppoinmentController extends Controller
{
    public function index()
    {
        // Login parent ki ID nikalenge
        $parentId = auth()->id();

        // parent_requests table se sirf pending aur approved status wali bookings uthayenge
        $appointments = \App\Models\ParentRequest::where('parent_id', $parentId)
            ->whereIn('status', ['pending', 'approved'])
            ->with(['child', 'hospital', 'vaccine', 'doctor']) // Saari relations aik sath load kar li
            ->latest()
            ->get();

        return view('parent.appoinment.index', compact('appointments'));
    }
    public function joinMeeting($id)
{
    // 1. Appointment (ParentRequest) ko doctor ke relation ke sath nikalenge
    $appointment = \App\Models\ParentRequest::with('doctor')->findOrFail($id);

    // 2. Security Check: Pehle dekhenge appointment Approved hai ya nahi
    if ($appointment->status !== 'approved') {
        return redirect()->back()->with('error', 'This appointment is not approved yet.');
    }

    // 3. Check karenge ke doctor ke paas Google Meet link save hai ya nahi
    if (!$appointment->doctor || !$appointment->doctor->google_meet_link) {
        return redirect()->back()->with('error', 'Doctor meeting link is not available. Please contact hospital.');
    }

    // 4. Check karenge ke doctor LIVE (Online) hai ya nahi
    if (!$appointment->doctor->is_online) {
        return redirect()->back()->with('error', 'Doctor is currently offline. Please wait for the doctor to come online.');
    }

    // 5. 🔥 Sab kuch sahi hai, ab Parent ko Direct Doctor ke Google Meet par redirect kar do!
    return redirect()->away($appointment->doctor->google_meet_link);
}



}
