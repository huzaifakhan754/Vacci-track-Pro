@extends('layouts.apex')

@section('title', 'Doctors - VacciTrack')

@section('content')
<div class="container-fluid px-0">

    <!-- Success Message Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="apex-page-heading mb-4">
        <h1>Doctors Management</h1>
        <p>Manage all registered doctors for your hospital and add new ones.</p>
    </div>

    <div class="row g-4">
        <!-- LEFT COLUMN: DOCTORS LIST TABLE -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <h5 class="fw-bold mb-3 text-secondary">Our Registered Doctors</h5>
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">SR #</th>
                                <th>Doctor Name</th>
                                <th>Specialization</th>
                                <th>Meeting</th>
                                <th>Meeting Link</th>
                                <th>Phone Number</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctors as $key => $doctor)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-medium text-dark">{{ $doctor->name }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2 py-1.5">
                                        {{ $doctor->specialization ?? 'General' }}
                                    </span>
                                </td>

                                <td class="status-cell">
                                    @if($doctor->is_online == 1)
                                    {{-- Green Button --}}
                                    <button type="button"
                                        data-url="{{ route('hospital.docters.toggle-status', $doctor->id) }}"
                                        class="btn btn-sm btn-success rounded-pill px-2 py-1 fw-bold toggle-status-btn"
                                        style="font-size: 11px;">
                                        <i class="bi bi-circle-fill text-white me-1" style="font-size: 6px;"></i>Online
                                    </button>
                                    @else
                                    {{-- Grey Button --}}
                                    <button type="button"
                                        data-url="{{ route('hospital.docters.toggle-status', $doctor->id) }}"
                                        class="btn btn-sm btn-secondary rounded-pill px-2 py-1 fw-medium toggle-status-btn"
                                        style="background-color: #6B7280; border: none; font-size: 11px; color: white;">
                                        <i class="bi bi-circle me-1" style="font-size: 6px;"></i> Offline
                                    </button>
                                    @endif
                                </td>
                                <td>
                                    @if($doctor->google_meet_link)
                                    <span class="text-success fw-medium">
                                        <i class="bi bi-check-circle-fill me-1"></i> Available
                                    </span>
                                    @else
                                    <span class="text-danger fw-medium">
                                        <i class="bi bi-x-circle-fill me-1"></i> Unavailable
                                    </span>
                                    @endif
                                </td>
                                  <td>
                                    @if($doctor->phone)
                                   <span class="text-success fw-medium">
                                        <i class="bi bi-check-circle-fill me-1"></i> Available
                                    </span>
                                    @else
                                    <span class="text-danger fw-medium">
                                        <i class="bi bi-x-circle-fill me-1"></i> Unavailable
                                    </span>
                                    @endif
                                </td>
                                <td class="text-muted" style="font-size: 13px;">
                                    {{ $doctor->created_at->format('d M, Y') }}
                                </td>
                                <td>
                                    <!-- Action Column: Edit aur Delete Buttons -->
                                    <div class="d-inline-flex gap-1 align-items-center">

                                        <!-- 1. Edit Button (Yeh click hote hi specific popup kholega) -->
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 fw-medium" style="font-size: 11px;" data-bs-toggle="modal" data-bs-target="#editDoctorModal{{ $doctor->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- 2. Delete Button -->
                                        <!-- 2. Delete Button (🔥 FIXED: route ko hospital.docters.destroy kiya h) -->
                                        <form action="{{ route('hospital.docters.destroy', $doctor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 fw-medium" style="font-size: 11px;">
                                                <i class="bi bi-trash3-fill"></i> Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                            <!-- 👇 EDIT DOCTOR MODAL (Har Row ke liye independent popup) -->
                            <div class="modal fade" id="editDoctorModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="editDoctorModalLabel{{ $doctor->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 15px;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold" id="editDoctorModalLabel{{ $doctor->id }}">Edit Doctor: {{ $doctor->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <form action="{{ route('hospital.docters.store') }}" method="POST">
                                                @csrf
                                                <!-- Hidden ID for update -->
                                                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

                                                <div class="mb-3">
                                                    <label class="form-label fw-medium small">Doctor Name</label>
                                                    <input type="text" name="name" class="form-control form-control-sm rounded-3" value="{{ $doctor->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-medium small">Specialization</label>
                                                    <input type="text" name="specialization" class="form-control form-control-sm rounded-3" value="{{ $doctor->specialization }}" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-medium small">Google Meet Link</label>
                                                    <input type="url" name="google_meet_link" class="form-control form-control-sm rounded-3" value="{{ $doctor->google_meet_link }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium small">WhatsApp Number</label>
                                                    <input type="text" name="phone" class="form-control form-control-sm rounded-3" value="{{ $doctor->phone ?? '' }}" placeholder="e.g. 923001234567" required>
                                                </div>

                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-sm btn-primary rounded-pill fw-bold">Update Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 👆 Edit Modal End -->

                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No doctors registered yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD NEW DOCTOR MODAL (Popup) -->
        <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="addDoctorModalLabel">Add New Doctor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hospital.docters.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-medium small">Doctor Name</label>
                                <input type="text" name="name" class="form-control form-control-sm rounded-3" placeholder="Enter doctor name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium small">Specialization</label>
                                <input type="text" name="specialization" class="form-control form-control-sm rounded-3" placeholder="e.g. Vaccinete" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium small">Google Meet Link</label>
                                <input type="url" name="google_meet_link" class="form-control form-control-sm rounded-3" placeholder="https://meet.google.com/..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium small">WhatsApp / Phone Number</label>
                                <!-- Add wale me placeholder rkhna, Edit wale me value="{{ $doctor->phone ?? '' }}" rkhna -->
                                <input type="text" name="phone" class="form-control form-control-sm rounded-3" placeholder="e.g. 923001234567" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill fw-bold">Save Doctor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Buttons par click event lagana
        document.body.addEventListener('click', function(e) {
            const button = e.target.closest('.toggle-status-btn');
            if (!button) return;

            e.preventDefault();

            const url = button.getAttribute('data-url');
            const parentTd = button.closest('.status-cell');

            // Background call
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Laravel ko batata hai ke AJAX request hai
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Bina page reload kiye UI change karna
                        if (data.is_online == 1) {
                            parentTd.innerHTML = `
                        <button type="button" 
                                data-url="${url}" 
                                class="btn btn-sm btn-success rounded-pill px-2 py-1 fw-bold toggle-status-btn" 
                                style="font-size: 11px;">
                            <i class="bi bi-circle-fill text-white me-1" style="font-size: 6px;"></i>Online
                        </button>
                    `;
                        } else {
                            parentTd.innerHTML = `
                        <button type="button" 
                                data-url="${url}" 
                                class="btn btn-sm btn-secondary rounded-pill px-2 py-1 fw-medium toggle-status-btn" 
                                style="background-color: #6B7280; border: none; font-size: 11px; color: white;">
                            <i class="bi bi-circle me-1" style="font-size: 6px;"></i> Offline
                        </button>
                    `;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
</script>
@endsection