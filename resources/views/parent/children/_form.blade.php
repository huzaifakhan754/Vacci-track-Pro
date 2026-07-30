<div class="d-flex justify-content-center my-2">
    <!-- Width tight fixed limit (450px) par set kar di hai -->
    <div class="w-100" style="max-width: 450px;">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3 p-sm-4">

            <!-- Header Section (compact margin) -->
            <div class="mb-3 text-center">
                <h4 class="fw-bold text-success mb-1 fs-5">Add Child</h4>
                <p class="text-muted small mb-0">Enter your child's details below</p>
            </div>

            <form action="" method="POST">
                {{-- Backend code start --}}
                <div class="d-flex flex-column gap-3">

                    <!-- Child Name -->
                    <div>
                        <label for="name" class="form-label fw-semibold text-dark small mb-1">
                            Child Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text"
                                class="form-control bg-light border-start-0 py-2 ps-2 @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                placeholder="Enter child's full name"
                                value="{{ old('name', $child->name ?? '') }}"
                                required>
                        </div>
                        @error('name')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="form-label fw-semibold text-dark small mb-1">
                            Date of Birth <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <input type="date"
                                class="form-control bg-light border-start-0 py-2 ps-2 @error('date_of_birth') is-invalid @enderror"
                                id="date_of_birth"
                                name="date_of_birth"
                                value="{{ old('date_of_birth', isset($child) ? $child->date_of_birth->format('Y-m-d') : '') }}"
                                required>
                        </div>
                        @error('date_of_birth')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="form-label fw-semibold text-dark small mb-1">
                            Gender <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <i class="bi bi-gender-ambiguous"></i>
                            </span>
                            <select class="form-select bg-light border-start-0 py-2 ps-2 @error('gender') is-invalid @enderror"
                                id="gender"
                                name="gender"
                                required>
                                <option value="" disabled selected hidden>Select gender</option>
                                @foreach (['male', 'female', 'other'] as $gender)
                                <option value="{{ $gender }}" @selected(old('gender', $child->gender ?? '') === $gender)>
                                    {{ ucfirst($gender) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('gender')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label for="blood_group" class="form-label fw-semibold text-dark small mb-1">
                            Blood Group <span class="text-muted fw-normal">(optional)</span>
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <i class="bi bi-droplet"></i>
                            </span>
                            <select class="form-select bg-light border-start-0 py-2 ps-2 @error('blood_group') is-invalid @enderror"
                                id="blood_group"
                                name="blood_group">
                                <option value="" disabled selected hidden>Select blood group</option>
                                @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                <option value="{{ $bg }}" @selected(old('blood_group', $child->blood_group ?? '') === $bg)>
                                    {{ $bg }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('blood_group')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons (Compact Margin Top) -->
                    <div class="d-flex align-items-center gap-2 pt-2">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-3 fw-medium btn-sm" style="background-color: #48bb78; border: none;">
                            Save Details
                        </button>
                        <a href="{{ route('parent.children.index') }}" class="btn btn-light px-4 py-2 rounded-3 fw-medium text-secondary btn-sm">
                            Cancel
                        </a>
                    </div>

                </div>
                {{-- Backend code end --}}
            </form>

        </div>
    </div>
</div>