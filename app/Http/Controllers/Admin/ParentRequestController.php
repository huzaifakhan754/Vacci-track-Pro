<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest;
use App\Models\Booking; 
use App\Mail\BookingApproved;
use App\Mail\BookingRejected;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentRequestController extends Controller
{
    /**
     * NOTE: This controller sends approval/rejection emails to parents using Laravel's Mailables.
     * Templates are located at: resources/views/emails/bookingApproved.blade.php and
     * resources/views/emails/bookingRejected.blade.php
     *
     * SMTP credentials should be provided via environment variables (see .env.example).
     */
    public function index(): View
    {
        $requests = ParentRequest::with(['parent', 'child', 'hospital', 'vaccine'])
            ->where('status', 'pending')
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
        $booking = Booking::create([
            'parent_id'          => $parentRequest->parent_id ?? 1,
            'child_id'           => $parentRequest->child_id,
            'vaccine_id'         => $parentRequest->vaccine_id,
            'hospital_id'        => $parentRequest->hospital_id, // Is ID se hospital panel filter karega
            'booking_date'       => $parentRequest->preferred_date ?? now()->toDateString(),
            'booking_time'       => $parentRequest->preferred_time ?? '09:00:00',
            'status'             => 'confirmed', // Hospital Panel ke check ke liye
            'vaccination_status' => 'pending',  // Shuru me vaccination pending rahegi
        ]);

        // 3. Send approval email (non-blocking)
        try {
            $parent = $parentRequest->parent;
            if ($parent && !empty($parent->email)) {
                $data = [
                    'parentName' => $parent->name ?? $parent->email,
                    'bookingId'  => $booking->id ?? null,
                    'childName'  => $parentRequest->child->name ?? null,
                    'vaccine'    => $parentRequest->vaccine->name ?? null,
                    'hospital'   => $parentRequest->hospital->name ?? null,
                    'date'       => optional($booking->booking_date)->toDateString() ?? $parentRequest->preferred_date,
                    'time'       => $booking->booking_time ?? $parentRequest->preferred_time,
                    'adminNotes' => $request->input('admin_notes'),
                ];

                Mail::to($parent->email)->send(new BookingApproved($data));
            }
        } catch (\Throwable $e) {
            logger()->error('Failed to send booking approval email: ' . $e->getMessage());
        }

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

        // Send rejection email (non-blocking)
        try {
            $parent = $parentRequest->parent;
            if ($parent && !empty($parent->email)) {
                $data = [
                    'parentName' => $parent->name ?? $parent->email,
                    'requestId'  => $parentRequest->id,
                    'childName'  => $parentRequest->child->name ?? null,
                    'vaccine'    => $parentRequest->vaccine->name ?? null,
                    'hospital'   => $parentRequest->hospital->name ?? null,
                    'date'       => $parentRequest->preferred_date,
                    'time'       => $parentRequest->preferred_time,
                    'adminNotes' => $request->input('admin_notes'),
                ];

                Mail::to($parent->email)->send(new BookingRejected($data));
            }
        } catch (\Throwable $e) {
            logger()->error('Failed to send booking rejection email: ' . $e->getMessage());
        }

        return back()->with('success', 'Request rejected.');
    }
}