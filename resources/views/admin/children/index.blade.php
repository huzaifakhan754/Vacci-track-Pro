@extends('layouts.apex')

@section('title', 'All Children - VacciTrack')

@section('content')
<style>
    :root {
        --vt-bg-card: rgba(255, 255, 255, 0.8);
        --vt-border-glass: rgba(0, 100, 255, 0.08);
        --vt-border-glass-hover: rgba(0, 120, 255, 0.2);
        --vt-text-primary: #1e293b;
        --vt-text-secondary: #475569;
        --vt-text-muted: #64748b;
        --vt-accent-blue: #0284c7;
        --vt-accent-indigo: #4f46e5;
    }

    /* Elegant Light Glassmorphism Card */
    .child-card {
        background: var(--vt-bg-card);
        backdrop-filter: blur(20px) saturate(1.2);
        -webkit-backdrop-filter: blur(20px) saturate(1.2);
        border: 1px solid var(--vt-border-glass) !important;
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.19, 1, 0.22, 1),
            border-color 0.4s ease,
            box-shadow 0.4s ease;
        position: relative;
    }

    .child-card:hover {
        transform: translateY(-6px);
        border-color: var(--vt-border-glass-hover) !important;
        box-shadow:
            0 10px 30px rgba(2, 132, 199, 0.06),
            0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Soft Gradient Avatar Ring based on Gender colors */
    .avatar-ring-boy {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9, #818cf8);
    }

    .avatar-ring-girl {
        background: linear-gradient(135deg, #f472b6, #ec4899, #f43f5e);
    }

    .avatar-ring-default {
        background: linear-gradient(135deg, #cbd5e1, #94a3b8, #64748b);
    }

    .avatar-ring {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        padding: 2.5px;
        flex-shrink: 0;
        position: relative;
    }

    .avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Gender Pill Badge */
    .gender-pill-boy {
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        color: #0369a1;
    }

    .gender-pill-girl {
        background: #fce7f3;
        border: 1px solid #fbcfe8;
        color: #be185d;
    }

    .gender-pill-default {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .gender-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    /* Subtle Light Divider Line */
    .glow-divider {
        height: 1px;
        margin: 20px 0;
        background: linear-gradient(90deg, transparent, rgba(0, 100, 255, 0.08), transparent);
    }

    /* Info Labels Styling */
    .info-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--vt-text-secondary);
        font-size: 13.5px;
        font-weight: 500;
        min-width: 0;
    }

    .info-label i {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        font-size: 13px;
        flex-shrink: 0;
    }

    .info-label .icon-dob {
        background: #fef3c7;
        color: #d97706;
    }

    .info-label .icon-blood {
        background: #fee2e2;
        color: #dc2626;
    }

    .info-value {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--vt-text-primary);
    }

    /* Action Buttons Configuration */
    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.25s ease;
        text-decoration: none;
        border: none;
        width: 100%;
    }
</style>
<div class="apex-page-heading mb-4">
    <h1>All Children</h1>
    <p>View all registered child profiles in the system.</p>
</div>
<!-- ── Dynamic Bootstrap Cards Grid ── -->
<div class="row g-4">
    @forelse ($children as $child)
    @php
    $genderLower = strtolower($child->gender);
    // Assigning ring gradients and icons dynamically based on gender data
    if ($genderLower === 'male' || $genderLower === 'boy') {
    $ringClass = 'avatar-ring-boy';
    $pillClass = 'gender-pill-boy';
    $avatarIcon = 'bi-gender-male text-primary';
    } elseif ($genderLower === 'female' || $genderLower === 'girl') {
    $ringClass = 'avatar-ring-girl';
    $pillClass = 'gender-pill-girl';
    $avatarIcon = 'bi-gender-female text-danger';
    } else {
    $ringClass = 'avatar-ring-default';
    $pillClass = 'gender-pill-default';
    $avatarIcon = 'bi-person-fill text-secondary';
    }
    @endphp
    <div class="col-md-6 col-xl-4">
        <article class="child-card p-4 h-100 d-flex flex-column shadow-sm bg-white">
            <!-- 1. Header Box (Child Name & Gender Badge) -->
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-ring {{ $ringClass }}">
                    <div class="avatar-inner">
                        <i class="bi {{ $avatarIcon }}"></i>
                    </div>
                </div>
                <div class="flex-grow-1 min-w-0">
                    <h5 class="mb-1 fw-bold text-truncate text-capitalize" style="font-family: 'Space Grotesk', sans-serif; font-size: 17px; letter-spacing: -0.01em; color: #0f172a;">
                        {{ $child->name }}
                    </h5>
                    <div>
                        <span class="gender-pill {{ $pillClass }}">
                            {{ ucfirst($child->gender) }}
                        </span>
                    </div>
                </div>
            </div>
            <!-- Subtle Horizontal Divider Line -->
            <div class="glow-divider"></div>
            <!-- 2. Technical Profile Details -->
            <div class="d-flex flex-column gap-3 mb-4 flex-grow-1">
                <!-- Date of Birth Item -->
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="info-label">
                        <i class="bi bi-person icon-parent"></i>
                        <span>Parent Name</span>
                    </div>
                    <div class="info-value text-secondary" style="color: #334155;">
                        {{ $child->parent->name }}
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="info-label">
                        <i class="bi bi-calendar-event icon-dob"></i>
                        <span>Date of Birth</span>
                    </div>
                    <div class="info-value text-secondary" style="color: #334155;">
                        {{ $child->date_of_birth->format('M d, Y') }}
                    </div>
                </div>
                <!-- Blood Group Item -->
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="info-label">
                        <i class="bi bi-droplet-fill icon-blood"></i>
                        <span>Blood Group</span>
                    </div>
                    <div class="info-value text-danger">
                        {{ $child->blood_group ?? '—' }}
                    </div>
                </div>
            </div>
            <!-- 3. Actions Button Grid Footer (Edit / Delete Layout) -->
            <div class="row g-2 w-100 mt-auto pt-2">
                <!-- Edit Button Link -->
                <div class="col-10 m-auto">
                    <a href="{{ route('admin.children.show', $child) }}" class="btn-action btn btn-primary" style="border-radius: 14px;">
                        <i class="bi bi-person-square"></i> View Profile
                    </a>
                </div>                
            </div>
        </article>
    </div>
    @empty
    <!-- Empty State Illustration Board -->
    <div class="col-12 text-center py-5 rounded-4 child-card bg-white shadow-sm">
        <i class="bi bi-people d-block text-secondary mb-3" style="font-size: 3rem; color: #94a3b8 !important;"></i>
        <h5 class="fw-bold text-slate-800 mb-1">No Children Added Yet</h5>
        <p class="small text-muted mb-0">Add your first child profile to start tracking and securing their vaccination schedules.</p>
    </div>
    @endforelse
</div>
@endsection