<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3" style="font-family: 'Poppins', sans-serif; background-color: #f8fafc;">
        <div class="w-100" style="max-width: 480px;">
            
            <!-- Logo / Header Section -->
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center text-primary bg-primary bg-opacity-10 rounded-3 p-3 mb-2" style="width: 55px; height: 55px;">
                    <i class="bi bi-shield-check fs-3"></i>
                </div>
                <h2 class="fw-bold h4 text-dark m-0" style="letter-spacing: -0.5px;">VacciTrack</h2>
                <p class="text-muted small mb-0">Child Vaccination Management System</p>
            </div>

            <!-- Main Elegant Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4 p-sm-5">
                    
                    <div class="mb-4">
                        <h3 class="fw-semibold h5 mb-1 text-dark">Create Account</h3>
                        <p class="text-muted small mb-0">Join us to manage and track child immunization seamlessly.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-medium text-secondary">Full Name</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-person"></i>
                                </span>
                                <x-text-input id="name" class="form-control border-0 bg-white py-2" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-medium text-secondary">Email Address</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <x-text-input id="email" class="form-control border-0 bg-white py-2" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone_no" class="form-label small fw-medium text-secondary">Phone Number</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <x-text-input id="phone_no" class="form-control border-0 bg-white py-2" type="text" name="phone_no" :value="old('phone_no')" required autocomplete="tel" placeholder="+92 300 1234567" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('phone_no')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label small fw-medium text-secondary">Register As</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-people"></i>
                                </span>
                                <select id="role" name="role" class="form-select border-0 bg-white py-2 shadow-none text-secondary small" required style="box-shadow: none;">
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select your role</option>
                                    <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
                                    <option value="hospital" {{ old('role') === 'hospital' ? 'selected' : '' }}>Hospital</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-medium text-secondary">Password</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <x-text-input id="password" class="form-control border-0 bg-white py-2" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label small fw-medium text-secondary">Confirm Password</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-shield-lock"></i>
                                </span>
                                <x-text-input id="password_confirmation" class="form-control border-0 bg-white py-2" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <x-primary-button class="btn btn-primary btn-sm py-2 fw-medium rounded-3 shadow-sm border-0  btn-custom-blue">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Login Redirect Link -->
                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">Already registered? <a href="{{ route('login') }}" class="text-primary fw-medium text-decoration-none hover-underline">Sign in instead</a></p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Shared Custom Style Overrides -->
    <style>
        .focus-within-primary:focus-within { border-color: #86b7fe !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important; }
        .btn-custom-blue { background-color: #0d6efd !important; color: white !important; font-size: 1rem !important; }
        .btn-custom-blue:hover { background-color: #0b5ed7 !important; transform: translateY(-1px); transition: all 0.2s ease; }
        .hover-underline:hover { text-decoration: underline !important; }
    </style>
</x-guest-layout>