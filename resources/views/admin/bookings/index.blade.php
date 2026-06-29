@extends('layouts.apex')

@section('title', 'Booking Details - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Booking Details</h1>
        <p class="text-muted mb-0">View all hospital vaccination bookings from parents.</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Parent</th>
                            <th>Child</th>
                            <th>Hospital</th>
                            <th>Vaccine</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                            <th>Vaccination Status</th>
                        </tr>
                    </thead>
                   <tbody>
    @forelse($bookings as $booking)
        <tr>
            <td class="align-middle text-capitalize fw-semibold text-dark">
                {{ $booking->child->parent->name ?? 'N/A' }}
            </td>

            <td class="align-middle text-capitalize text-secondary">
                {{ $booking->child->name ?? $booking->child_name ?? 'N/A' }}
            </td>

            <td class="align-middle text-secondary fw-medium">
    {{ $booking->hospital->name ?? $booking->hospital_name ?? 'Not Assigned' }}
</td>

            <td class="align-middle fw-medium text-secondary">
                {{ $booking->vaccine->name ?? $booking->vaccine_name ?? 'N/A' }}
            </td>

            <td class="align-middle text-dark">
                {{ \Carbon\Carbon::parse($booking->preferred_date ?? $booking->created_at)->format('M d, Y') }}
                <small class="text-muted d-block">{{ $booking->preferred_time ?? 'Anytime' }}</small>
            </td>

            <td class="align-middle">
                @if($booking->status == 'approved' || $booking->status == 'completed')
                    <span class="badge px-3 py-2 border border-success text-success bg-success-subtle rounded fw-bold" style="font-size: 0.8rem;">
                        Confirmed
                    </span>
                @else
                    <span class="badge px-3 py-2 border border-warning text-warning bg-warning-subtle rounded fw-bold" style="font-size: 0.8rem;">
                        Pending Approval
                    </span>
                @endif
            </td>

            <td class="align-middle">
                @if($booking->status == 'completed')
                    <span class="badge px-3 py-2 bg-success text-white rounded fw-bold" style="font-size: 0.8rem;">
                         Done / Completed
                    </span>
                @elseif($booking->status == 'approved')
                    <span class="badge px-3 py-2 bg-info text-white rounded fw-bold" style="font-size: 0.8rem;">
                         Approved
                    </span>
                @else
                    <span class="badge px-3 py-2 bg-light text-secondary border rounded fw-medium" style="font-size: 0.8rem;">
                        Awaiting
                    </span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted py-4">
                No bookings found.
            </td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
