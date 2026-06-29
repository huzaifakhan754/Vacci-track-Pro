<header class="apex-header">
    <div class="apex-search">
        <i class="bi bi-search"></i>
        <input type="search" placeholder="Search anything..." aria-label="Search">
        <kbd>⌘K</kbd>
    </div>

    <div class="d-flex align-items-center gap-2">
        @role('admin')
            <a href="{{ route('admin.hospitals.create') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-plus-lg"></i> Add Hospital
            </a>
        @endrole
        @role('parent')
            <a href="{{ route('parent.children.create') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-plus-lg"></i> Add Child
            </a>
        @endrole
        @role('hospital')
            <a href="{{ route('hospital.appointments.index') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-clipboard2-pulse"></i> Appointments
            </a>
        @endrole

        <button type="button" class="apex-icon-btn" title="Dark mode">
            <i class="bi bi-moon"></i>
        </button>
        <button type="button" class="apex-icon-btn" title="Theme">
            <i class="bi bi-palette"></i>
        </button>
        <button type="button" class="apex-icon-btn" title="Notifications">
            <i class="bi bi-bell"></i>
            @if (auth()->user()->hasRole('admin') && ($pendingRequestsCount ?? 0) > 0)
                <span class="apex-notify-dot"></span>
            @endif
        </button>
        <div class="apex-avatar ms-1">{{ strtoupper(substr(auth()->user()->name ?? 'VT', 0, 2)) }}</div>
    </div>
</header>
