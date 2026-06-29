<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest;
use App\Models\Booking; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentRequestController extends Controller
{
    public function index(): View
    {
        $requests = ParentRequest::with(['parent', 'child', 'hospital', 'vaccine'])
            ->latest()
            ->get();

        return view('admin.requests.index', compact('requests'));
    }

    public function approve(Request $request, ParentRequest $parentRequest): RedirectResponse
    {
        if ($parentRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        // 1. Parent Request ka status database me approved set karein
        $parentRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->input('admin_notes'),
        ]);

        // 2. SYSTEM BRIDGE: Hospital Panel ke liye automatic Booking entry create karein
        Booking::create([
            'parent_id'          => $parentRequest->parent_id ?? 1,
            'child_id'           => $parentRequest->child_id,
            'vaccine_id'         => $parentRequest->vaccine_id,
            'hospital_id'        => $parentRequest->hospital_id, // Is ID se hospital panel filter karega
            'booking_date'       => $parentRequest->preferred_date ?? now()->toDateString(),
            'booking_time'       => $parentRequest->preferred_time ?? '09:00:00',
            'status'             => 'confirmed', // Hospital Panel ke check ke liye
            'vaccination_status' => 'pending',  // Shuru me vaccination pending rahegi
        ]);

        return back()->with('success', 'Request approved successfully and sent to hospital!');
    }

    public function reject(Request $request, ParentRequest $parentRequest): RedirectResponse
    {
        if ($parentRequest->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $parentRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return back()->with('success', 'Request rejected.');
    }
}