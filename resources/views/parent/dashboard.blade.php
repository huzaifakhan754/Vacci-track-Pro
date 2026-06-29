@extends('layouts.apex')

@section('title', 'Parent Dashboard - VacciTrack')

@section('content')
<div class="apex-page-heading mb-4">
    <h1>Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}. Manage your children's vaccinations from here.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4">
        @include('partials.apex.kpi-card', [
        'title' => 'My Children',
        'value' => $totalChildren,
        'icon' => 'bi-people-fill',
        'iconBg' => '#D1FAE5',
        'iconColor' => '#10B981',
        'sparkColor' => '#10B981',
        'trend' => 'Registered',
        'trendUp' => true,
        ])
    </div>
    <div class="col-sm-6 col-xl-4">
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
    <div class="col-sm-6 col-xl-4">
        @include('partials.apex.kpi-card', [
        'title' => 'Pending Requests',
        'value' => $pendingRequests,
        'icon' => 'bi-inbox-fill',
        'iconBg' => '#FEF3C7',
        'iconColor' => '#F59E0B',
        'sparkColor' => '#F59E0B',
        'trend' => $pendingRequests > 0 ? 'Awaiting approval' : 'All clear',
        'trendUp' => $pendingRequests === 0,
        ])
    </div>
</div>

<div class="apex-panel">
    <div class="apex-panel-header d-flex justify-content-between align-items-center">
        <h2>Upcoming Vaccination Dates</h2>
        <a href="{{ route('parent.vaccination-dates.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
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
            <tbody class="align-middle">
                @foreach($upcomingVaccines as $vaccine)
                @php
                // 🔍 String saaf karna: "BCG (Tuberculosis)" ko tod kar sirf "BCG" nikalna
                $cleanName = trim(explode('(', $vaccine['vaccine_name'])[0]);

                // Database se 'BCG' ya usse milti julti vaccine ki sahi ID dhoondna
                $dbVaccine = \App\Models\Vaccine::where('name', $cleanName)
                ->orWhere('name', 'LIKE', '%' . $cleanName . '%')
                ->first();

                // Pehle se bheji gayi request ka status check karna
                $checkRequest = false;
                if ($dbVaccine) {
                $checkRequest = \App\Models\ParentRequest::where('child_id', $vaccine['child_id'])
                ->where('vaccine_id', $dbVaccine->id)
                ->latest()
                ->first();
                }

                $daysLeft = (int)$vaccine['days_left'];
                @endphp

                {{-- 🔥 STRICT FIX: Agar status approved, vaccinated, ya not_vaccinated ho chuka hai, to row ko list se GAIB kar do! --}}
                @if($checkRequest && in_array($checkRequest->status, ['approved', 'vaccinated', 'not_vaccinated', 'completed']))
                @continue
                @endif

                <tr class="border-bottom">
                    {{-- Child Name --}}
                    <td class="py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-light text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span class="fw-bold text-dark text-capitalize">{{ $vaccine['child_name'] }}</span>
                        </div>
                    </td>

                    {{-- Vaccine Name --}}
                    <td class="py-3">
                        <span class="fw-semibold text-secondary">{{ $vaccine['vaccine_name'] }}</span>
                    </td>

                    {{-- Date --}}
                    <td class="py-3 text-muted">
                        <i class="bi bi-calendar3 me-1 text-primary"></i>
                        {{ \Carbon\Carbon::parse($vaccine['due_date'])->format('M d, Y') }}
                        <small class="text-xs d-block text-capitalize">{{ \Carbon\Carbon::parse($vaccine['due_date'])->format('l') }}</small>
                    </td>

                    {{-- Khubsoorat Dynamic Time Badge --}}
                    <td class="py-3">
                        @if($daysLeft == 0)
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill fw-bold animate__animated animate__pulse animate__infinite">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> Today Due
                        </span>
                        @elseif($daysLeft <= 3)
                            <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill fw-bold">
                            <i class="bi bi-clock-history me-1"></i> {{ $daysLeft }} Days Left
                            </span>
                            @else
                            <span class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-pill fw-semibold">
                                <i class="bi bi-hourglass-split me-1"></i> {{ $daysLeft }} Days Left
                            </span>
                            @endif
                    </td>

                    {{-- Action Buttons --}}
                    <td class="py-3 text-end">
                        @if ($daysLeft <= 3 && $daysLeft>= 0)
                            @if($checkRequest && $checkRequest->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm border border-warning d-inline-block">
                                <i class="spinner-border spinner-border-sm me-1" role="status"></i> Pending Approval
                            </span>
                            @elseif($checkRequest && $checkRequest->status == 'rejected')
                            <a href="{{ route('parent.bookings.index', [
                                        'child_id' => $vaccine['child_id'],
                                        'child_name' => $vaccine['child_name'],
                                        'vaccine_id' => $dbVaccine ? $dbVaccine->id : '',
                                        'vaccine_name' => $vaccine['vaccine_name'],
                                        'due_date' => \Carbon\Carbon::parse($vaccine['due_date'])->format('Y-m-d')
                                    ]) }}" class="btn btn-sm btn-danger rounded-pill shadow-sm px-3 py-2 fw-bold d-inline-flex align-items-center transition-all hover-scale">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Rejected (Re-try)
                            </a>
                            @else
                            <a href="{{ route('parent.bookings.index', [
                                        'child_id' => $vaccine['child_id'],
                                        'child_name' => $vaccine['child_name'],
                                        'vaccine_id' => $dbVaccine ? $dbVaccine->id : '',
                                        'vaccine_name' => $vaccine['vaccine_name'],
                                        'due_date' => \Carbon\Carbon::parse($vaccine['due_date'])->format('Y-m-d')
                                    ]) }}" class="btn btn-sm btn-success rounded-pill shadow-sm px-4 py-2 fw-bold d-inline-flex align-items-center transition-all hover-scale" style="background: linear-gradient(135deg, #00b09b, #96c93d); border: none;">
                                <i class="bi bi-bookmark-plus-fill me-1"></i> Book Now
                            </a>
                            @endif
                            @else
                            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill fw-normal shadow-sm">
                                <i class="bi bi-lock-fill me-1 text-secondary"></i> Upcoming
                            </span>
                            @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection