@extends('layouts.apex')

@section('title', 'My Children - VacciTrack')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div class="apex-page-heading">
            <h1>My Children</h1>
            <p>Add and manage your children's vaccination details.</p>
        </div>
        <a href="{{ route('parent.children.create') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
            <i class="bi bi-plus-lg"></i> Add Child
        </a>
    </div>

    <div class="apex-panel">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-3">Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($children as $child)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $child->name }}</td>
                                <td>{{ $child->date_of_birth->format('M d, Y') }}</td>
                                <td>{{ ucfirst($child->gender) }}</td>
                                <td>{{ $child->blood_group ?? '—' }}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('parent.children.edit', $child) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('parent.children.destroy', $child) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Remove this child?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No children added yet. Add your first child to get started.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
