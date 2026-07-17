@extends('layouts.apex')

@section('title', 'Vaccination Reports - VacciTrack')

@section('content')
<div class="mb-4">
    <div class="apex-page-heading mb-4">
        <h1>Vaccination Reports</h1>
        <p class="text-muted mb-0">Child vaccination report — filter by date for date-wise reports.</p>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="date" class="form-label">Filter by Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $date }}">
                </div>
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="apex-panel">
        <div class="apex-panel-header">
            <h2 class="h6 mb-0">
                @if ($date)
                Report for {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                @else
                All Vaccination Records
                @endif
            </h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>CHILD</th>
                            <th>PARENT</th>
                            <th>VACCINE</th>
                            <th>HOSPITAL</th>
                            <th>DOCTOR</th>
                            <th>ADMINISTERED DATE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td class="text-capitalize fw-semibold text-dark">
                                {{ $report->child->name ?? 'N/A' }}
                            </td>

                            <td class="text-capitalize text-secondary">
                                {{ $report->child->parent->name ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="badge bg-light text-primary border border-primary-subtle px-2.5 py-1.5">
                                    {{ $report->vaccine->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="text-muted">
                                {{ $report->hospital->name ?? 'N/A' }}
                            </td>
                           
                            <td class="text-muted">
                                {{ $report->doctor->name ?? 'N/A' }}
                            </td>
                            <td class="text-success fw-medium">
                                {{ $report->updated_at ? \Carbon\Carbon::parse($report->updated_at)->format('M d, Y') : 'Done' }}
                            </td>

                            <td>
                                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1">
                                    <i class="bi bi-check-circle-fill me-1"></i> Vaccinated
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted fw-medium">
                                No vaccinated records found in the system.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection