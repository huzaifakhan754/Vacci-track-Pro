<header class="apex-header">
    <!-- Toggle Button updated with data-target -->
            <div id="menu" onclick="toggleMenu()">☰</div>

    <div class="apex-search">
        <i class="bi bi-search"></i>
        <input type="search" placeholder="Search anything..." aria-label="Search">
        <kbd>⌘K</kbd>
    </div>

    <div id="navbar" class="d-flex align-items-center gap-2">
        @role('admin')
        <a href="{{ route('admin.hospitals.create') }}"  class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
            <i class="bi bi-plus-lg"></i> Add Hospital
        </a>
        @endrole
        @role('parent')
        <a href="{{ route('parent.children.create') }}" class="apex-btn-primary d-inline-flex align-items-center gap-2 text-decoration-none">
            <i class="bi bi-plus-lg"></i> Add Child
        </a>
        @endrole
        @role('hospital')
        <button type="button" class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
            <i class="bi bi-plus-circle me-1"></i> Add Doctor
        </button>
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