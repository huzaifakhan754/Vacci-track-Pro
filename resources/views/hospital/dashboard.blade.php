@extends('layouts.apex')

@section('title', 'Hospital Dashboard - VacciTrack')

@section('content')
<div class="apex-page-heading mb-4">
    <h1>Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}. Manage appointments and update vaccination status for {{ $hospital->name }}.</p>
</div>

<div class="row g-3 mb-4">
    <!-- 👇 1. Total Doctors Card (Value ko $totalDoctors kiya hai) -->
    <div class="col-sm-6 col-xl-4">
        @include('partials.apex.kpi-card', [
        'title' => 'Total Doctors',
        'value' => $totalDoctors, // 👈 Puraane variable ko is se replace karo
        'icon' => 'bi-person-vcard',
        'iconBg' => '#E0F2FE',
        'iconColor' => '#0284C7',
        'sparkColor' => '#0284C7',
        'trend' => 'Registered',
        'trendUp' => true,
        ])
    </div>
    <div class="col-sm-6 col-xl-4">
        @include('partials.apex.kpi-card', [
        'title' => 'Pending Vaccinations',
        'value' => $pendingVaccinations,
        'icon' => 'bi-hourglass-split',
        'iconBg' => '#FEF3C7',
        'iconColor' => '#F59E0B',
        'sparkColor' => '#F59E0B',
        'trend' => 'Needs update',
        'trendUp' => $pendingVaccinations === 0,
        ])
    </div>
    <div class="col-sm-6 col-xl-4">
        @include('partials.apex.kpi-card', [
        'title' => 'Completed',
        'value' => $completedVaccinations,
        'icon' => 'bi-check-circle-fill',
        'iconBg' => '#DBEAFE',
        'iconColor' => '#3B82F6',
        'sparkColor' => '#3B82F6',
        'trend' => 'Vaccinated',
        'trendUp' => true,
        ])
    </div>
</div>
<div class="apex-panel mb-4">
    <div class="apex-panel-header d-flex justify-content-between align-items-center">
        <h2>Recent Appointments</h2>
        <a href="{{ route('hospital.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th class="ps-3">Child</th>
                    <th>Vaccine</th>
                    <th>Date</th>
                    <th>Vaccination Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAppointments as $booking)
                <tr>
                    <td class="align-middle text-capitalize fw-semibold text-dark">
                        {{ $booking->child->name ?? 'N/A' }}
                    </td>

                    <td class="align-middle fw-medium text-secondary">
                        {{ $booking->vaccine->name ?? 'N/A' }}
                    </td>

                    <td class="align-middle text-dark">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                    </td>

                    <td class="align-middle">
                        @if($booking->vaccination_status == 'vaccinated')
                        <span class="badge px-3 py-2 bg-success text-white rounded fw-bold" style="font-size: 0.8rem;">
                            Vaccinated
                        </span>
                        @elseif($booking->vaccination_status == 'not_vaccinated')
                        <span class="badge px-3 py-2 bg-danger text-white rounded fw-bold" style="font-size: 0.8rem;">
                            Not Vaccinated
                        </span>
                        @else
                        <span class="badge px-3 py-2 bg-warning text-dark rounded fw-semibold" style="font-size: 0.8rem;">
                            Pending
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        No appointments booked for your hospital yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
    </div>
</div>

<div class="apex-card">
    <h2 class="h6 fw-semibold mb-2" style="color:#111827;">Quick Actions</h2>
    <p class="text-muted small mb-3">Mark vaccinations as completed when patients receive their dose.</p>
    <a href="{{ route('hospital.appointments.index') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
        <i class="bi bi-clipboard2-pulse"></i> Manage Appointments
    </a>
</div>

<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="addDoctorModalLabel">Add New Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hospital.docters.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-medium small">Doctor Name</label>
                                <input type="text" name="name" class="form-control form-control-sm rounded-3" placeholder="Enter doctor name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium small">Specialization</label>
                                <input type="text" name="specialization" class="form-control form-control-sm rounded-3" placeholder="e.g. Vaccinete" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium small">Google Meet Link</label>
                                <input type="url" name="google_meet_link" class="form-control form-control-sm rounded-3" placeholder="https://meet.google.com/..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium small">WhatsApp / Phone Number</label>
                                <!-- Add wale me placeholder rkhna, Edit wale me value="{{ $doctor->phone ?? '' }}" rkhna -->
                                <input type="text" name="phone" class="form-control form-control-sm rounded-3" placeholder="e.g. 923001234567" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill fw-bold">Save Doctor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection