@extends('layouts.apex')

@section('title', 'Vaccine List - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4"><h1>Vaccine List</h1>
        <p class="text-muted mb-0">View and manage vaccine availability (available / unavailable).</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Vaccine</th>
                            <th>Description</th>
                            <th>Recommended Age</th>
                            <th>Availability</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vaccines as $vaccine)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $vaccine->name }}</td>
                                <td>{{ $vaccine->description ?? '—' }}</td>
                                <td>{{ $vaccine->recommended_age_days !== null ? round($vaccine->recommended_age_days / 30) . ' months' : '—' }}</td>
                                <td>
                                    @if ($vaccine->is_available)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Unavailable</span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <form action="{{ route('admin.vaccines.availability', $vaccine) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_available" value="{{ $vaccine->is_available ? '0' : '1' }}">
                                        <button type="submit" class="btn btn-sm {{ $vaccine->is_available ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            Mark {{ $vaccine->is_available ? 'Unavailable' : 'Available' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No vaccines in the system.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
