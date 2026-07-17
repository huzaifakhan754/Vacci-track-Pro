@extends('layouts.apex')

@section('title', 'Appointments - VacciTrack')

@section('content')
<div class="apex-page-heading mb-4">
    <h1>Appointments</h1>
    <p>Update vaccination status for bookings at {{ $hospital->name }}.</p>
</div>

<div class="apex-panel">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Parent</th>
                        <th>Child</th>
                        <th>Vaccine</th>
                        <th>Dr Name</th>
                        <th>Booking Date</th>
                        <th>Booking Status</th>                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $appointment)
                    <tr>
                        <td class="ps-3">{{ $appointment->parent->name }}</td>
                        <td class="fw-medium">{{ $appointment->child->name }}</td>
                        <td>{{ $appointment->vaccine->name }}</td>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>{{ $appointment->preferred_date->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-primary">{{ ucfirst($appointment->status) }}</span>
                        </td>                        
                        <td>
                            <div class="d-flex flex-row gap-2">
                                <form action="{{ route('hospital.appointments.update', $appointment->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="vaccination_status" value="vaccinated">
                                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center gap-2 fw-bold text-white shadow-sm"
                                        style="background: linear-gradient(45deg, #2ecc71, #27ae60); border: none; border-radius: 6px; padding: 5px 10px; transition: all 0.2s ease; font-size: 0.9rem;">
                                        <i class="bi bi-check2-circle" style="font-size: 1.1rem;"></i>
                                        Vaccinated
                                    </button>
                                </form>

                                <form action="{{ route('hospital.appointments.update', $appointment->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="vaccination_status" value="not_vaccinated">
                                    <button type="submit" class="btn w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold btn-outline-danger shadow-sm"
                                        style="border-radius: 6px; padding: 5px 10px; border-width: 2px; transition: all 0.2s ease; font-size: 0.9rem;">
                                        <i class="bi bi-x-circle" style="font-size: 1rem;"></i>
                                        Reject
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No appointments booked for your hospital yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection