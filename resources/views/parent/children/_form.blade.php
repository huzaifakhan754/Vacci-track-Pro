<div class="mb-3">
    <label for="name" class="form-label">Child Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
           value="{{ old('name', $child->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="date_of_birth" class="form-label">Date of Birth</label>
    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth"
           value="{{ old('date_of_birth', isset($child) ? $child->date_of_birth->format('Y-m-d') : '') }}" required>
    @error('date_of_birth')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="gender" class="form-label">Gender</label>
    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
        <option value="">Select gender</option>
        @foreach (['male', 'female', 'other'] as $gender)
            <option value="{{ $gender }}" @selected(old('gender', $child->gender ?? '') === $gender)>{{ ucfirst($gender) }}</option>
        @endforeach
    </select>
    @error('gender')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="blood_group" class="form-label">Blood Group (optional)</label>
    <input type="text" class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group"
           value="{{ old('blood_group', $child->blood_group ?? '') }}" placeholder="e.g. B+">
    @error('blood_group')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
