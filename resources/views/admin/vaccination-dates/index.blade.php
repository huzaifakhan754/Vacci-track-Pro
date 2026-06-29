@extends('layouts.apex')

@section('title', 'Vaccination Dates - VacciTrack')

@section('content')
<div class="mb-4">
    <div class="apex-page-heading mb-4">
        <h1>Vaccination Details</h1>
        <p class="text-muted mb-0">Date and time of all vaccinations details for all children.</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Child</th>
                            <th>Parent</th>
                            <th>Vaccine</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($allRequests as $request)
        @php
            // Agar request me preferred_date ho to wo, nahi to jis din request bani wo date
            $targetDate = $request->preferred_date ? \Carbon\Carbon::parse($request->preferred_date) : \Carbon\Carbon::parse($request->created_at);
            $daysLeft = (int) \Carbon\Carbon::now()->startOfDay()->diffInDays($targetDate->startOfDay(), false);
        @endphp
        <tr>
            <td class="align-middle text-capitalize fw-bold text-dark">
                {{ $request->child->name ?? $request->child_name ?? 'N/A' }}
            </td>

            <td class="align-middle text-secondary text-capitalize">
                {{ $request->child->parent->name ?? 'N/A' }}
            </td>

            <td class="align-middle fw-medium text-secondary">
                {{ $request->vaccine->name ?? $request->vaccine_name ?? 'N/A' }}
            </td>

            <td class="align-middle text-dark fw-semibold">
                {{ $targetDate->format('M d, Y') }}
            </td>

            <td class="align-middle small">
                @if($daysLeft < 0)
                    <span class="text-danger fw-bold">Overdue ({{ abs($daysLeft) }} days ago)</span>
                @elseif($daysLeft == 0)
                    <span class="text-warning fw-bold">Due Today</span>
                @else
                    <span class="text-success fw-medium">{{ $daysLeft }} Days Left</span>
                @endif
            </td>

            <td class="align-middle">
                @if($request->status == 'completed')
                    <span class="badge px-3 py-2 border border-success text-success bg-success-subtle rounded fw-bold" style="font-size: 0.82rem;">
                        Completed
                    </span>
                @elseif($request->status == 'approved')
                    <span class="badge px-3 py-2 border border-info text-info bg-info-subtle rounded fw-bold" style="font-size: 0.82rem;">
                        Approved
                    </span>
                @elseif($request->status == 'pending')
                    <span class="badge px-3 py-2 border border-warning text-warning bg-warning-subtle rounded fw-bold" style="font-size: 0.82rem;">
                        Pending
                    </span>
                @else
                    <span class="badge px-3 py-2 bg-light text-secondary border rounded fw-medium" style="font-size: 0.82rem;">
                        Not Booked
                    </span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">
                No vaccination records found in database.
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection