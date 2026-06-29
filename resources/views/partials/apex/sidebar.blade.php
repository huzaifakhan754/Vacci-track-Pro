<aside class="apex-sidebar">
    <div class="d-flex align-items-center gap-3 px-4 py-4">
        <div class="d-flex align-items-center justify-content-center rounded-2" style="width:36px;height:36px;background:#10B981;">
            <i class="bi bi-lightning-charge-fill text-white"></i>
        </div>
        <div>
            <span class="text-white fw-bold" style="font-size:14px;">VacciTrack</span>
            <span class="text-secondary text-uppercase ms-1" style="font-size:10px;letter-spacing:0.1em;">Panel</span>
        </div>
    </div>

    <nav class="flex-grow-1 overflow-auto px-3 pb-3">
        @role('admin')
            <div class="mb-4">
                <p class="apex-nav-section">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="apex-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </div>
            <div class="mb-4">
                <p class="apex-nav-section">Vaccination</p>
                <a href="{{ route('admin.children.index') }}" class="apex-nav-link {{ request()->routeIs('admin.children.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> All Children
                </a>
                <a href="{{ route('admin.vaccination-dates.index') }}" class="apex-nav-link {{ request()->routeIs('admin.vaccination-dates.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Vaccination Dates
                </a>
                <a href="{{ route('admin.reports.index') }}" class="apex-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Reports
                </a>
                <a href="{{ route('admin.vaccines.index') }}" class="apex-nav-link {{ request()->routeIs('admin.vaccines.*') ? 'active' : '' }}">
                    <i class="bi bi-droplet"></i> Vaccine List
                </a>
            </div>
            <div class="mb-4">
                <p class="apex-nav-section">Management</p>
                <a href="{{ route('admin.requests.index') }}" class="apex-nav-link {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}">
                    <i class="bi bi-inbox"></i> Parent Requests
                    @if (($pendingRequestsCount ?? 0) > 0)
                        <span class="apex-badge">{{ $pendingRequestsCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.hospitals.index') }}" class="apex-nav-link {{ request()->routeIs('admin.hospitals.*') ? 'active' : '' }}">
                    <i class="bi bi-hospital"></i> Hospitals
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="apex-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-check"></i> Bookings
                </a>
                <a href="{{ route('profile.edit') }}" class="apex-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> My Profile
                </a>
            </div>
        @endrole

        @role('parent')
            <div class="mb-4">
                <p class="apex-nav-section">Overview</p>
                <a href="{{ route('parent.dashboard') }}" class="apex-nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </div>
            <div class="mb-4">
                <p class="apex-nav-section">My Account</p>
                <a href="{{ route('parent.children.index') }}" class="apex-nav-link {{ request()->routeIs('parent.children.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> My Children
                </a>
                <a href="{{ route('parent.vaccination-dates.index') }}" class="apex-nav-link {{ request()->routeIs('parent.vaccination-dates.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Vaccination Dates
                </a>
                <a href="{{ route('parent.bookings.index') }}" class="apex-nav-link {{ request()->routeIs('parent.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-hospital"></i> Book Hospital
                </a>
                <a href="{{ route('parent.reports.index') }}" class="apex-nav-link {{ request()->routeIs('parent.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i> Vaccination Reports
                </a>
                <a href="{{ route('profile.edit') }}" class="apex-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> My Profile
                </a>
            </div>
        @endrole

        @role('hospital')
            <div class="mb-4">
                <p class="apex-nav-section">Overview</p>
                <a href="{{ route('hospital.dashboard') }}" class="apex-nav-link {{ request()->routeIs('hospital.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
                <a href="{{ route('hospital.appointments.index') }}" class="apex-nav-link {{ request()->routeIs('hospital.appointments.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-pulse"></i> Update Vaccine Status
                </a>              
                <a href="{{ route('profile.edit') }}" class="apex-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> My Profile
                </a>
            </div>
        @endrole
    </nav>

    <div class="border-top border-secondary px-4 py-3" style="border-color:#1F2937!important;">
        <div class="d-flex align-items-center gap-3">
            <div class="apex-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'VT', 0, 2)) }}</div>
            <div class="flex-grow-1 min-w-0">
                <p class="text-white mb-0 small fw-medium text-truncate">{{ auth()->user()->name }}</p>
                <p class="text-secondary mb-0" style="font-size:12px;">
                    @if (auth()->user()->hasRole('admin')) Admin
                    @elseif (auth()->user()->hasRole('parent')) Parent
                    @elseif (auth()->user()->hasRole('hospital')) Hospital
                    @else User
                    @endif
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="apex-icon-btn text-secondary" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
