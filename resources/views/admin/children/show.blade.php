@extends('layouts.apex')

@section('title', $child->name . ' - VacciTrack')

@section('content')

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="apex-page-heading mb-4">
            <h1>{{ $child->name }}</h1>
            <p class="text-muted mb-0">Child profile details</p>
        </div>
        <div><a href="{{ route('admin.children.index') }}" class="btn btn-success">Back to List</a></div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="apex-panel-header">
                    <h2 class="h6 mb-0">Personal Information</h2>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">
                            <i class="bi text-primary bi-person icon-parent"></i> Parent
                        </dt>
                        <dd class="col-sm-8">{{ $child->parent->name }}</dd>
                        <dt class="col-sm-4 text-muted">
                            <i class="bi text-info bi-calendar-event icon-dob"></i> Date of Birth
                        </dt>
                        <dd class="col-sm-8">{{ $child->date_of_birth->format('M d, Y') }}</dd>
                        <dt class="col-sm-4 text-muted">
                            <i class="bi text-warning bi-gender-male icon-gender"></i> Gender
                        </dt>
                        <dd class="col-sm-8">{{ $child->gender ? ucfirst($child->gender) : '—' }}</dd>
                        <dt class="col-sm-4 text-muted">
                            <i class="bi text-danger bi-droplet icon-blood"></i> Blood Group
                        </dt>
                        <dd class="col-sm-8 text-danger">{{ $child->blood_group ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="apex-panel-header">
                    <h2 class="h6 mb-0">Vaccination History</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Vaccine</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($child->vaccinationSchedules as $schedule)
                                <tr>
                                    <td class="ps-3">{{ $schedule->vaccine->name }}</td>
                                    <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                        $badge = match ($schedule->status) {
                                        'completed' => 'bg-success',
                                        'missed' => 'bg-danger',
                                        default => 'bg-warning text-dark',
                                        };
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ ucfirst($schedule->status) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">No vaccination records.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($child->bookings->isNotEmpty())
    <div class="apex-panel">
        <div class="apex-panel-header">
            <h2 class="h6 mb-0">Hospital Bookings</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Hospital</th>
                            <th>Vaccine</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($child->bookings as $booking)
                        <tr>
                            <td class="ps-3">{{ $booking->hospital->name }}</td>
                            <td class="text-success"><span>{{ $booking->vaccine->name }}</span></td>
                            <td>{{ $booking->booking_date->format('M d, Y') }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($booking->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @endsection