<x-guest-layout>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5 px-3" style="font-family: 'Poppins', sans-serif; background-color: #f8fafc;">
        <div class="w-100" style="max-width: 420px;">
            
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
                        <h3 class="fw-semibold h5 mb-1 text-dark">LogIn</h3>
                        <p class="text-muted small mb-0">Please enter your details to access your account.</p>
                    </div>

                    <!-- Session Status (Laravel Default) -->
                    <x-auth-session-status class="alert alert-success border-0 small text-center mb-4 py-2" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-medium text-secondary">Email Address</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <x-text-input id="email" class="form-control border-0 bg-white py-2" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-medium text-secondary">Password</label>
                            <div class="input-group rounded-3 border overflow-hidden focus-within-primary">
                                <span class="input-group-text bg-light border-0 text-muted px-3">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <x-text-input id="password" class="form-control border-0 bg-white py-2" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" style="box-shadow: none;" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block mt-1 small" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pt-1">
                            <div class="form-check m-0">
                                <input id="remember_me" type="checkbox" class="form-check-input border-secondary-subtle" name="remember" style="cursor: pointer;">
                                <label class="form-check-label text-muted small user-select-none" for="remember_me" style="cursor: pointer;">Remember me</label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-medium text-primary hover-underline">Forgot password?</a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <x-primary-button class="btn btn-primary btn-lg py-2 fw-medium rounded-3 shadow-sm border-0 btn-custom-blue">
                                {{ __('Log in') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-medium text-decoration-none hover-underline">Register now</a></p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Extra Simple Custom CSS for smooth input fields and layout stability -->
    <style>
        .focus-within-primary:focus-within { border-color: #86b7fe !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important; }
        .btn-custom-blue { background-color: #0d6efd !important; color: white !important; font-size: 1rem !important; }
        .btn-custom-blue:hover { background-color: #0b5ed7 !important; transform: translateY(-1px); transition: all 0.2s ease; }
        .hover-underline:hover { text-decoration: underline !important; }
    </style>
</x-guest-layout>