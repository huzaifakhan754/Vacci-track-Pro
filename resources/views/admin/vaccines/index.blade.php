@extends('layouts.apex')

@section('title', 'Vaccine List - VacciTrack')

@section('content')
    <div class="mb-4">
        <!-- Heading & Add Vaccine Button Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="apex-page-heading mb-0">
                <h1>Vaccine List</h1>
                <p class="text-muted mb-0">View and manage vaccine availability (available / unavailable).</p>
            </div>
            
            <!-- Add Vaccine Trigger Button -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVaccineModal">
                <i class="bi bi-plus-lg me-1"></i>Add Vaccine
            </button>
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
    </div>

    <!-- Add Vaccine Modal (Popup) -->
    <div class="modal fade" id="addVaccineModal" tabindex="-1" aria-labelledby="addVaccineModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVaccineModalLabel">Add New Vaccine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- Form action apne route ke hisaab se update kar lein (e.g. route('admin.vaccines.store')) --}}
                <form action="{{ route('admin.vaccines.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Vaccine Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="e.g. Polio-1" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Brief description of the vaccine..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="recommended_age_days" class="form-label">Recommended Age (in Days)</label>
                            <input type="number" name="recommended_age_days" class="form-control" id="recommended_age_days" placeholder="e.g. 60 (for 2 months)" required>
                        </div>

                        <div class="mb-3">
                            <label for="is_available" class="form-label">Availability Status</label>
                            <select name="is_available" class="form-control" id="is_available">
                                <option value="1" selected>Available</option>
                                <option value="0">Unavailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Vaccine</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection