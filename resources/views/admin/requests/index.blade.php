@extends('layouts.apex')

@section('title', 'Parent Requests - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Parent Requests</h1>
        <p class="text-muted mb-0">Approve or reject appointment requests from parents.</p>
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
                            <th>Doctor</th>
                            <th>Vaccine</th>
                            <th>Preferred Date</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $parentRequest)
                            <tr>
                                <td class="ps-3">{{ $parentRequest->parent->name ?? '—'  }}</td>
                                <td>{{ $parentRequest->child->name }}</td>
                                <td>{{ $parentRequest->hospital?->name ?? '—' }}</td>
                                <td>{{ $parentRequest->doctor?->name ?? '—' }}</td>
                                <td>{{ $parentRequest->vaccine?->name ?? '—' }}</td>
                                <td>{{ $parentRequest->preferred_date?->format('M d, Y') ?? '—' }}</td>
                                <td>
                                    @php
                                        $badge = match ($parentRequest->status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-warning text-dark',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($parentRequest->status) }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    @if ($parentRequest->status === 'pending')
                                        <form action="{{ route('admin.requests.approve', $parentRequest) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.requests.reject', $parentRequest) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Reject this request?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Processed</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($parentRequest->message)
                                <tr class="table-light">
                                    <td colspan="7" class="ps-3 small text-muted">
                                        <strong>Message:</strong> {{ $parentRequest->message }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <!-- colspan="7" ko badal kar 8 kar diya h -->
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox d-block mb-2" style="font-size: 2rem;"></i>
                                    No new pending parent requests at this time.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
