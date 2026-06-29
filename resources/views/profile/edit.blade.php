@extends('layouts.apex')

@section('title', 'My Profile - VacciTrack')

@section('content')
    <div class="apex-page-heading mb-4">
        <h1>My Profile</h1>
        <p>Update your account information and password.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="apex-card h-100">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        <div class="col-lg-6">
            <div class="apex-card mb-4">
                @include('profile.partials.update-password-form')
            </div>
            <div class="apex-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
