@extends('layouts.apex')

@section('title', 'Hospitals - VacciTrack')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div class="apex-page-heading">
            <h1>Hospitals</h1>
            <p>Manage hospital details for vaccination bookings.</p>
        </div>
        <a href="{{ route('admin.hospitals.create') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
            <i class="bi bi-plus-lg"></i> Add Hospital
        </a>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Name</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hospitals as $hospital)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $hospital->name }}</td>
                                <td>{{ $hospital->address }}</td>
                                <td>{{ $hospital->location }}</td>
                                <td>{{ $hospital->phone }}</td>
                                <td>{{ $hospital->email }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.hospitals.edit', $hospital) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.hospitals.destroy', $hospital) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this hospital?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hospitals found. Add your first hospital.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
