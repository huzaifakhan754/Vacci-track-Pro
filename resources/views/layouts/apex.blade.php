<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Apex Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --apex-sidebar: #111827;
            --apex-bg: #F9FAFB;
            --apex-accent: #10B981;
            --apex-accent-dark: #059669;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--apex-bg);
            min-height: 100vh;
        }

        .apex-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 256px;
            height: 100vh;
            background-color: var(--apex-sidebar);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
        }

        .apex-sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .apex-sidebar .apex-avatar {
            min-width: 40px;
        }

        .apex-main {
            margin-left: 256px;
            min-height: 100vh;
            transition: margin-left 0.25s ease;
        }

        .apex-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease;
        }

        .apex-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        .apex-nav-section {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6B7280;
            padding: 0 12px;
            margin-bottom: 8px;
        }

        .apex-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: 8px;
            color: #9CA3AF;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all 0.15s ease;
        }

        .apex-nav-link:hover {
            background-color: #1F2937;
            color: #fff;
        }

        .apex-nav-link.active {
            background-color: #1F2937;
            color: var(--apex-accent);
        }

        .apex-nav-link i {
            font-size: 18px;
            width: 18px;
        }

        .apex-badge {
            margin-left: auto;
            background-color: var(--apex-accent);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .apex-header {
            background: #fff;
            border-bottom: 1px solid #E5E7EB;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .apex-search {
            position: relative;
            max-width: 420px;
            width: 100%;
        }

        .apex-search input {
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 10px 16px 10px 40px;
            font-size: 14px;
            width: 100%;
        }

        .apex-search input:focus {
            background-color: #fff;
            border-color: var(--apex-accent);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            outline: none;
        }

        .apex-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
        }

        .apex-search kbd {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 10px;
            padding: 2px 6px;
            border: 1px solid #E5E7EB;
            border-radius: 4px;
            background: #fff;
            color: #9CA3AF;
        }

        .apex-btn-primary {
            background-color: var(--apex-accent);
            border: none;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 16px;
            border-radius: 12px;
        }

        .apex-btn-primary:hover {
            background-color: var(--apex-accent-dark);
            color: #fff;
        }

        .apex-icon-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            border-radius: 8px;
            color: #6B7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .apex-icon-btn:hover {
            background-color: #F3F4F6;
            color: #374151;
        }

        .apex-notify-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #EF4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .apex-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--apex-accent);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .apex-card {
            background: #fff;
            border: 1px solid #F3F4F6;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 20px;
        }

        .apex-kpi-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .apex-sparkline {
            height: 40px;
            margin-top: 16px;
        }

        .apex-tab-group {
            background: #F3F4F6;
            border-radius: 8px;
            padding: 4px;
            display: inline-flex;
            gap: 2px;
        }

        .apex-tab-group .btn {
            font-size: 12px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            color: #6B7280;
            background: transparent;
        }

        .apex-tab-group .btn.active {
            background: #fff;
            color: #111827;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        .apex-donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .apex-legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .apex-progress {
            height: 8px;
            border-radius: 999px;
            background: #F3F4F6;
        }

        .apex-progress-bar {
            height: 100%;
            border-radius: 999px;
        }

        .apex-content {
            padding: 24px;
        }

        .apex-page-heading h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .apex-page-heading p {
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 0;
        }

        .apex-panel {
            background: #fff;
            border: 1px solid #F3F4F6;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .apex-panel .card-body {
            padding: 0;
        }

        .apex-panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid #F3F4F6;
            background: #fff;
        }

        .apex-panel-header h2 {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .apex-content .table {
            margin-bottom: 0;
            font-size: 14px;
        }

        .apex-content .table thead th {
            background: #F9FAFB;
            color: #6B7280;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #F3F4F6;
            padding: 12px 16px;
        }

        .apex-content .table tbody td {
            padding: 14px 16px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }

        .apex-content .table tbody tr:hover {
            background-color: #F9FAFB;
        }

        .apex-content .btn-primary,
        .apex-content .btn-success {
            background-color: var(--apex-accent);
            border-color: var(--apex-accent);
        }

        .apex-content .btn-primary:hover,
        .apex-content .btn-success:hover {
            background-color: var(--apex-accent-dark);
            border-color: var(--apex-accent-dark);
        }

        .apex-content .btn-outline-primary {
            color: var(--apex-accent);
            border-color: var(--apex-accent);
        }

        .apex-content .btn-outline-primary:hover {
            background-color: var(--apex-accent);
            border-color: var(--apex-accent);
            color: #fff;
        }

        .apex-content .form-control:focus,
        .apex-content .form-select:focus {
            border-color: var(--apex-accent);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        .apex-profile-section h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .apex-profile-section .lead {
            font-size: 0.875rem;
            color: #6B7280;
            margin-bottom: 1.25rem;
        }

        .apex-profile-section .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .apex-profile-section .form-control {
            border-radius: 8px;
            border-color: #E5E7EB;
            padding: 10px 14px;
            font-size: 14px;
        }

        .apex-content .btn-danger {
            border-radius: 8px;
            font-weight: 600;
        }

        .apex-content .card {
            border: 1px solid #F3F4F6;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .apex-chart-area {
            height: 220px;
            width: 100%;
        }

        #menu{
            display: none;
        }
        @media (max-width: 991.98px) {
            .apex-sidebar {
                transform: translateX(-100%);
            }

            .apex-main {
                margin-left: 0;
            }

            .apex-header {
                padding: 0 16px;
                gap: 0.75rem;
            }

            .apex-search {
                max-width: 100%;
                width: 50%;
            }

            .apex-header .d-flex.align-items-center {
                display: none;
            }

            button.apex-btn-primary {
                display: none;
            }

            button.apex-icon-btn {
                display: none;
            }

            .add-hos {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .apex-search input {
                padding: 10px 14px 10px 40px;
            }

            .apex-header {
                height: auto;
                padding: 0.75rem 16px;
            }

            .apex-header .apex-avatar {
                width: 69px;
                height: 50px;
                font-size: 11px;
            }
           


            .apex-icon-btn {
                width: 36px;
                height: 36px;
            }

            .apex-btn-primary {
                display: none;
            }

            .add-hos {
                display: none;
            }

            #menu {
                font-size: 1rem;
                color: white;
                background: #10b981;
                width: 8vw;
                justify-content: center;
                display: flex;
                text-align: center;
                align-items: center;
                height: 8vw;
            }

            #navbar{
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @auth
    @php
    $hospitalId = auth()->user()->hospital?->id;
    $navbarDoctor = $hospitalId ? \App\Models\Doctor::where('hospital_id', $hospitalId)->first() : null;
    @endphp
    @endauth

    @include('partials.apex.sidebar')

    <div class="apex-main">

        {{-- WRAPPER TO FORCIBLY INJECT TOGGLE BUTTON RIGHT INSIDE NAVBAR HTML STRUCTURE --}}
        <div class="position-relative">
            @include('partials.apex.header')

            {{-- JAVASCRIPT INJECTION TO PLACE BUTTON INSIDE THE FLEX HEADER --}}
            @if(isset($navbarDoctor) && $navbarDoctor)

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const headerRightGroup = document.querySelector('.apex-header .d-flex.align-items-center') || document.querySelector('.apex-header');
                    const toggleSource = document.getElementById('apex-navbar-toggle-source');
                    if (headerRightGroup && toggleSource) {
                        const formElement = toggleSource.querySelector('form');
                        // Profile Avatar ya Bell icon se pehle toggle form inject karein
                        headerRightGroup.insertBefore(formElement, headerRightGroup.firstChild);
                    }
                });
            </script>
            @endif
        </div>

        <main class="apex-content">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.botpress.cloud/webchat/v3.6/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2026/06/30/23/20260630234951-2M2KUXFW.js" defer></script>
    <script>
        let btn = document.getElementById("apexSidebarToggle");
        let sidebbar = document.getElementById('apex-sidebar');

        var navCheck = false;

        function toggleMenu() {
            if (navCheck == false) {
                sidebbar.style.transform = "translateX(0%)"
                navCheck = true;
                btn.innerHTML = "X";
            } else {
                navCheck = false;
                sidebbar.style.transform = "translateX(-100%)"
                btn.innerHTML = "☰";
            }
        }
    </script>
</body>

</html>