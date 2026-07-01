<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VacciTrack')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background-color: #f8f9fa; }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #fff;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .main-content { padding: 1.5rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-semibold" href="{{ url('/') }}">VacciTrack</a>
            <div class="d-flex align-items-center gap-3 ms-auto">
                @auth
                    <span class="navbar-text text-white">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
                <aside class="col-md-3 col-lg-2 sidebar p-3">
                    <nav class="nav flex-column">
                        @role('admin')
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            <a class="nav-link {{ request()->routeIs('admin.children.*') ? 'active' : '' }}" href="{{ route('admin.children.index') }}">All Children</a>
                            <a class="nav-link {{ request()->routeIs('admin.vaccination-dates.*') ? 'active' : '' }}" href="{{ route('admin.vaccination-dates.index') }}">Vaccination Dates</a>
                            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">Vaccination Reports</a>
                            <a class="nav-link {{ request()->routeIs('admin.vaccines.*') ? 'active' : '' }}" href="{{ route('admin.vaccines.index') }}">Vaccine List</a>
                            <a class="nav-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}" href="{{ route('admin.requests.index') }}">Parent Requests</a>
                            <a class="nav-link {{ request()->routeIs('admin.hospitals.*') ? 'active' : '' }}" href="{{ route('admin.hospitals.index') }}">Hospitals</a>
                            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">Bookings</a>
                        @endrole

                        @role('parent')
                            <a class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}" href="{{ route('parent.dashboard') }}">Dashboard</a>
                            <a class="nav-link {{ request()->routeIs('parent.children.*') ? 'active' : '' }}" href="{{ route('parent.children.index') }}">My Children</a>
                            <a class="nav-link {{ request()->routeIs('parent.vaccination-dates.*') ? 'active' : '' }}" href="{{ route('parent.vaccination-dates.index') }}">Vaccination Dates</a>
                            <a class="nav-link {{ request()->routeIs('parent.bookings.*') ? 'active' : '' }}" href="{{ route('parent.bookings.index') }}">Book Hospital</a>
                            <a class="nav-link {{ request()->routeIs('parent.reports.*') ? 'active' : '' }}" href="{{ route('parent.reports.index') }}">Vaccination Reports</a>
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">My Profile</a>
                        @endrole

                        @role('hospital')
                            <a class="nav-link {{ request()->routeIs('hospital.dashboard') ? 'active' : '' }}" href="{{ route('hospital.dashboard') }}">Dashboard</a>
                            <a class="nav-link" href="#">Update Vaccine Status</a>
                        @endrole
                    </nav>
                </aside>
                <main class="col-md-9 col-lg-10 main-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            @else
                <main class="col-12 main-content">
                    @yield('content')
                </main>
            @endauth
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.botpress.cloud/webchat/v3.6/inject.js"></script>
<script src="https://files.bpcontent.cloud/2026/06/30/23/20260630234951-2M2KUXFW.js" defer></script>
    
</body>
</html>
