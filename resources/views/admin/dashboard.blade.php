@extends('layouts.apex')

@section('title', 'Admin Dashboard - VacciTrack')

@section('content')
    <div class="apex-page-heading mb-4">
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}. Here's what's happening with the vaccination system today.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            @include('partials.apex.kpi-card', [
                'title' => 'Total Children',
                'value' => $totalChildren,
                'icon' => 'bi-people-fill',
                'iconBg' => '#D1FAE5',
                'iconColor' => '#10B981',
                'sparkColor' => '#10B981',
                'trend' => 'Registered',
                'trendUp' => true,
            ])
        </div>
        <div class="col-sm-6 col-xl-3">
            @include('partials.apex.kpi-card', [
                'title' => 'Hospitals',
                'value' => $totalHospitals,
                'icon' => 'bi-hospital-fill',
                'iconBg' => '#CCFBF1',
                'iconColor' => '#14B8A6',
                'sparkColor' => '#14B8A6',
                'trend' => 'Active',
                'trendUp' => true,
            ])
        </div>
        <div class="col-sm-6 col-xl-3">
            @include('partials.apex.kpi-card', [
                'title' => 'Upcoming Vaccinations',
                'value' => $upcomingVaccinations,
                'icon' => 'bi-calendar-check-fill',
                'iconBg' => '#DBEAFE',
                'iconColor' => '#3B82F6',
                'sparkColor' => '#3B82F6',
                'trend' => 'Scheduled',
                'trendUp' => true,
            ])
        </div>
        <div class="col-sm-6 col-xl-3">
            @include('partials.apex.kpi-card', [
                'title' => 'Pending Requests',
                'value' => $pendingRequests,
                'icon' => 'bi-inbox-fill',
                'iconBg' => '#FEF3C7',
                'iconColor' => '#F59E0B',
                'sparkColor' => '#F59E0B',
                'trend' => $pendingRequests > 0 ? 'Needs review' : 'All clear',
                'trendUp' => $pendingRequests === 0,
            ])
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="apex-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="h6 fw-semibold mb-1" style="color:#111827;">Overview</h2>
                        <p class="text-muted small mb-0">Vaccination activity overview</p>
                    </div>
                    <div class="apex-tab-group">
                        <button type="button" class="btn active">Schedules</button>
                        <button type="button" class="btn">Requests</button>
                        <button type="button" class="btn">Bookings</button>
                    </div>
                </div>
                <svg class="apex-chart-area" viewBox="0 0 600 220" preserveAspectRatio="none" aria-hidden="true">
                    <defs>
                        <linearGradient id="adminAreaGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10B981" stop-opacity="0.35"/>
                            <stop offset="100%" stop-color="#10B981" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <path d="M0,180 C80,120 120,200 200,140 S360,60 440,100 520,80 600,110 L600,220 L0,220 Z" fill="url(#adminAreaGrad)"/>
                    <path d="M0,180 C80,120 120,200 200,140 S360,60 440,100 520,80 600,110" fill="none" stroke="#10B981" stroke-width="3"/>
                </svg>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="apex-card h-100">
                <h2 class="h6 fw-semibold mb-1" style="color:#111827;">Quick Stats</h2>
                <p class="text-muted small mb-4">System summary at a glance</p>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Children registered</span>
                            <span class="fw-semibold">{{ $totalChildren }}</span>
                        </div>
                        <div class="apex-progress">
                            <div class="apex-progress-bar" style="width:{{ min(100, $totalChildren * 10) }}%;background:#10B981;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Upcoming doses</span>
                            <span class="fw-semibold">{{ $upcomingVaccinations }}</span>
                        </div>
                        <div class="apex-progress">
                            <div class="apex-progress-bar" style="width:{{ min(100, $upcomingVaccinations * 15) }}%;background:#3B82F6;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">Pending requests</span>
                            <span class="fw-semibold">{{ $pendingRequests }}</span>
                        </div>
                        <div class="apex-progress">
                            <div class="apex-progress-bar" style="width:{{ min(100, $pendingRequests * 25) }}%;background:#F59E0B;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="apex-panel">
        <div class="apex-panel-header d-flex justify-content-between align-items-center">
            <h2>Upcoming Vaccination Dates</h2>
            <a href="{{ route('admin.vaccination-dates.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Child</th>
                        <th>Vaccine</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentSchedules as $schedule)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $schedule->child->name }}</td>
                            <td>{{ $schedule->vaccine->name }}</td>
                            <td>{{ $schedule->scheduled_date->format('M d, Y') }}</td>
                            <td><span class="badge rounded-pill bg-warning text-dark">{{ ucfirst($schedule->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No upcoming vaccinations scheduled.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
