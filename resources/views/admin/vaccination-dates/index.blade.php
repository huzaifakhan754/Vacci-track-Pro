@extends('layouts.apex')

@section('title', 'Vaccination Dates - VacciTrack')

@section('content')
<div class="mb-4">
    <div class="apex-page-heading mb-4">
        <h1>Vaccination Details</h1>
        <p class="text-muted mb-0">Date and time of all vaccination details for children.</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Child Name</th>
                            <th>Parent Name</th>
                            <th>Vaccine</th>
                            <th>Preferred Date</th>
                            <th>Preferred Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allRequests as $request)
                        @php
                            // Agar preferred_date na ho to created_at ko use karenge (Fail-safe)
                            $dateSource = $request->preferred_date ? \Carbon\Carbon::parse($request->preferred_date) : \Carbon\Carbon::parse($request->created_at);
                            $timeSource = \Carbon\Carbon::parse($request->created_at);
                        @endphp
                        <tr>                            
                            <!-- Child Name -->
                            <td class="align-middle text-capitalize fw-bold text-dark ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-primary rounded-circle p-2 me-2 d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <span>{{ $request->child->name ?? $request->child_name ?? 'N/A' }}</span>
                                </div>
                            </td>                        
                            
                            <!-- Parent Name -->
                            <td class="align-middle text-secondary text-capitalize">                                 
                                {{ $request->child->parent->name ?? 'N/A' }}                                
                            </td>
                            
                            <!-- Vaccine Name -->
                            <td class="align-middle fw-medium text-secondary">
                                <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded">
                                    {{ $request->vaccine->name ?? $request->vaccine_name ?? 'N/A' }}
                                </span>
                            </td>

                            <!-- Preferred Date (Formatted: Jul 16, 2026) -->
                            <td class="align-middle text-dark fw-semibold">
                                {{ $dateSource->format('M d, Y') }}
                            </td>

                            <!-- Preferred Time (Real Time display from Database) -->
                            <td class="align-middle text-secondary fw-medium">
                                @if($request->preferred_time && $request->preferred_time != 'N/A')
                                    {{ $request->preferred_time }}
                                @else
                                    <!-- Yeh aapke database ka actual time exact format me nikalega -->
                                    {{ $timeSource->format('h:i A') }}
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="align-middle">
                                @if(strtolower($request->status) == 'approved')
                                <span class="badge px-3 py-2 border border-success text-success bg-success-subtle rounded fw-bold" style="font-size: 0.82rem;">
                                    Approved
                                </span>
                                @elseif(strtolower($request->status) == 'rejected')
                                <span class="badge px-3 py-2 border border-danger text-danger bg-danger-subtle rounded fw-bold" style="font-size: 0.82rem;">
                                    Rejected
                                </span>
                                @else
                                <span class="badge px-3 py-2 bg-light text-secondary border rounded fw-medium" style="font-size: 0.82rem;">
                                    {{ ucfirst($request->status) }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x d-block mb-2" style="font-size: 2rem;"></i>
                                No dynamic vaccination records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection