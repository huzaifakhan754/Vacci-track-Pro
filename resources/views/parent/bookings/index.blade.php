@extends('layouts.apex')

@section('title', 'Book Hospital - VacciTrack')

@section('content')
    <div class="mb-4">
        <div class="apex-page-heading mb-4">
            <h1>Book Hospital</h1>
            <p class="text-muted mb-0">Search hospitals and request an appointment for vaccination.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="apex-panel">
                <div class="apex-panel-header">
                    <h2 class="h6 mb-0">Request Appointment</h2>
                </div>
                <div class="card-body">
                    @if ($children->isEmpty())
                        <p class="text-muted mb-0">Please <a href="{{ route('parent.children.create') }}">add a child</a> before booking.</p>
                    @else
                        <form action="{{ route('parent.bookings.store') }}" method="POST">
                            @csrf
                            
                            {{-- 1. Child Selection (Auto-selects if data comes from dashboard button) --}}
                            <div class="mb-3">
                                <label for="child_id" class="form-label">Child</label>
                                <select class="form-select @error('child_id') is-invalid @enderror" id="child_id" name="child_id" required>
                                    <option value="">Select child</option>
                                    @foreach ($children as $child)
                                        <option value="{{ $child->id }}" 
                                            @selected(old('child_id', request('child_id')) == $child->id)>
                                            {{ $child->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('child_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- 2. Hospital Selection (Manual selection by parent) --}}
                            <div class="mb-3">
                                <label for="hospital_id" class="form-label">Hospital</label>
                                <select class="form-select @error('hospital_id') is-invalid @enderror" id="hospital_id" name="hospital_id" required>
                                    <option value="">Select hospital</option>
                                    @foreach ($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}" @selected(old('hospital_id') == $hospital->id)>
                                            {{ $hospital->name }} — {{ $hospital->location }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hospital_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- 3. Vaccine Selection (Auto-selects if data comes from dashboard button) --}}
                            <div class="mb-3">
                                <label for="vaccine_id" class="form-label">Vaccine</label>
                                <select class="form-select @error('vaccine_id') is-invalid @enderror" id="vaccine_id" name="vaccine_id" required>
                                    <option value="">Select vaccine</option>
                                    @foreach ($vaccines as $vaccine)
                                        <option value="{{ $vaccine->id }}" 
                                            @selected(old('vaccine_id', request('vaccine_id')) == $vaccine->id)>
                                            {{ $vaccine->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vaccine_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- 4. Preferred Date (Auto-fills from dashboard or allows fresh input) --}}
                            <div class="mb-3">
                                <label for="preferred_date" class="form-label">Preferred Date</label>
                                <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date"
                                       value="{{ old('preferred_date', request('due_date')) }}" min="{{ now()->toDateString() }}" required>
                                @error('preferred_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- 5. Message (Optional) --}}
                            <div class="mb-3">
                                <label for="message" class="form-label">Message (optional)</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit Request</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Side Table: Available Hospitals & My Requests --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="apex-panel-header">
                    <h2 class="h6 mb-0">Available Hospitals</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Name</th>
                                    <th>Location</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hospitals as $hospital)
                                    <tr>
                                        <td class="ps-3">{{ $hospital->name }}</td>
                                        <td>{{ $hospital->location }}</td>
                                        <td>{{ $hospital->phone }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-3">No hospitals available.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="apex-panel">
                <div class="apex-panel-header">
                    <h2 class="h6 mb-0">My Requests</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-3">Child</th>
                                    <th>Hospital</th>
                                    <th>Vaccine</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $request)
                                    <tr>
                                        <td class="ps-3">{{ $request->child->name }}</td>
                                        <td>{{ $request->hospital?->name ?? '—' }}</td>
                                        <td>{{ $request->vaccine?->name ?? '—' }}</td>
                                        <td>{{ $request->preferred_date?->format('M d, Y') ?? '—' }}</td>
                                        <td>
                                            @php
                                                $badge = match ($request->status) {
                                                    'approved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    default => 'bg-warning text-dark',
                                                };
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ ucfirst($request->status) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No requests submitted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



















