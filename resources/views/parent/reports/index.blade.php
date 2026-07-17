@extends('layouts.apex')

@section('title', 'Vaccination Reports - VacciTrack')

@section('content')
<div class="mb-4">
    <div class="apex-page-heading mb-4">
        <h1>Vaccination Reports</h1>
        <p class="text-muted mb-0">History of completed and missed vaccinations for your children.</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Child</th>
                            <th>Vaccine</th>
                            <th>Scheduled Date</th>
                            <th>Hospital</th>
                            <th>Doctor Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse($reports as $report)
                        <tr>
                            <td class="ps-3 fw-bold text-dark text-capitalize">{{ $report->child->name }}</td>
                            <td class="fw-semibold text-secondary">{{ $report->vaccine->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->updated_at)->format('M d, Y') }}</td>
                            <td>{{ $report->hospital->name ?? 'Registered Medical Center' }}</td>
                            <td>{{ $report->doctor->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Vaccinated
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex gap-2 justify-content-end">
                                    {{--  View Button: Yeh naye tab me PDF ko sirf kholega --}}
                                    <a href="{{ route('parent.reports.view', $report->id) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-eye-fill me-1"></i> View
                                    </a>

                                    {{--  Download Button: Yeh file ko computer me direct download karega --}}
                                    <a href="{{ route('parent.reports.download', $report->id) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold text-white" style="background: linear-gradient(135deg, #00b09b, #96c93d); border: none;">
                                        <i class="bi bi-download me-1"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No completed vaccination reports available yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection