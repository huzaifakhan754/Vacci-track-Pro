@extends('layouts.apex')

@section('title', 'All Children - VacciTrack')

@section('content')
    <div class="apex-page-heading mb-4">
        <h1>All Children</h1>
        <p>View all registered child profiles in the system.</p>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Name</th>
                            <th>Parent</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($children as $child)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $child->name }}</td>
                                <td>{{ $child->parent->name }}</td>
                                <td>{{ $child->date_of_birth->format('M d, Y') }}</td>
                                <td>{{ $child->gender ? ucfirst($child->gender) : '—' }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.children.show', $child) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No children registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
