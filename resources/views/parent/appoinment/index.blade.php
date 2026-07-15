@extends('layouts.apex')

@section('title', 'Vaccination Dates - VacciTrack')

@section('content')
<!-- 🔥 Premium Light-Mode Glassmorphism Styles -->
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
        --vt-accent-green: #16a34a;
        --vt-accent-amber: #d97706;
        --vt-gradient-whatsapp: linear-gradient(135deg, #25d366, #128c7e);
        --vt-gradient-blue: linear-gradient(135deg, #3b82f6, #1d4ed8);
        --vt-gradient-locked: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    /* Elegant Light Glassmorphism Card */
    .appt-card {
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
    
    .appt-card:hover {
        transform: translateY(-6px);
        border-color: var(--vt-border-glass-hover) !important;
        box-shadow:
            0 10px 30px rgba(2, 132, 199, 0.06),
            0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Soft Gradient Avatar Ring */
    .avatar-ring {
        width: 52px; height: 52px; border-radius: 50%; padding: 2.5px; flex-shrink: 0;
        background: linear-gradient(135deg, #38bdf8, #818cf8, #34d399);
        position: relative;
    }
    .avatar-inner {
        width: 100%; height: 100%; border-radius: 50%;
        background: #ffffff;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--vt-accent-blue);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
    }

    /* Clean Light Vaccine Pill Badge */
    .vaccine-pill {
        display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px;
        background: #f0fdf4; border: 1px solid #dcfce7;
        color: #166534; font-size: 11.5px; font-weight: 600; letter-spacing: 0.02em; white-space: nowrap;
    }

    /* Subtle Light Divider Line */
    .glow-divider {
        height: 1px; margin: 20px 0;
        background: linear-gradient(90deg, transparent, rgba(0, 100, 255, 0.08), transparent);
    }

    /* Info Badge Rows Styling */
    .info-label {
        display: flex; align-items: center; gap: 10px; color: var(--vt-text-secondary); font-size: 13.5px; font-weight: 500; min-width: 0;
    }
    .info-label i {
        width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
        border-radius: 9px; font-size: 13px; flex-shrink: 0;
    }
    .info-label .icon-hospital { background: #f0f9ff; color: var(--vt-accent-blue); }
    .info-label .icon-doctor { background: #eef2ff; color: var(--vt-accent-indigo); }
    .info-label .icon-status { background: #f0fdf4; color: var(--vt-accent-green); }
    .info-label .icon-status.pending { background: #fffbeb; color: var(--vt-accent-amber); }
    
    .info-value { font-size: 13.5px; font-weight: 600; color: var(--vt-text-primary); }

    /* Light Dynamic Status Badges */
    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .status-approved { background: #dcfce7; border: 1px solid #bbf7d0; color: #166534; }
    .status-pending { background: #fef3c7; border: 1px solid #fde68a; color: #92400e; }

    /* Smooth Micro Pulsing Animation for Pending Status */
    .pulse-dot {
        width: 8px; height: 8px; border-radius: 50%; background: var(--vt-accent-amber); position: relative; flex-shrink: 0;
    }
    .pulse-dot::after {
        content: ''; position: absolute; inset: -3px; border-radius: 50%;
        border: 1.5px solid var(--vt-accent-amber); animation: pulseRing 1.5s ease-out infinite;
    }
    @keyframes pulseRing {
        0% { transform: scale(0.8); opacity: 0.8; }
        100% { transform: scale(2); opacity: 0; }
    }

    /* Symmetrical Action Buttons Layout */
    .btn-action {
        display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 16px;
        border-radius: 14px; border: none; font-size: 13px; font-weight: 600; cursor: pointer;
        transition: all 0.25s ease; text-decoration: none;
    }
    .btn-chat { background: var(--vt-gradient-whatsapp); color: #fff; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.15); }
    .btn-chat:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(37, 211, 102, 0.25); color: #fff; }
    .btn-join { background: var(--vt-gradient-blue); color: #fff; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15); }
    .btn-join:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(59, 130, 246, 0.25); color: #fff; }

    /* Frosted Beautiful Shimmer Effect For Locked States */
    .btn-locked {
        background: var(--vt-gradient-locked); color: #94a3b8; border: 1px solid #e2e8f0;
        cursor: not-allowed; box-shadow: none; position: relative; overflow: hidden;
    }
    .btn-locked .lock-shimmer {
        position: absolute; inset: 0;
        background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, 0.6) 45%, rgba(255, 255, 255, 0.8) 50%, rgba(255, 255, 255, 0.6) 55%, transparent 60%);
        animation: shimmerSlide 3s ease-in-out infinite;
    }
    @keyframes shimmerSlide {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
</style>

<div class="py-3">
    <!-- Modern Light Header Layout -->
    <div class="mb-5">
        <h1 class="fw-bold text-slate-800 mb-1" style="font-family: 'Space Grotesk', sans-serif; font-size: 28px; color: #0f172a;">My Appointments</h1>
        <p class="text-muted mb-0" style="font-size: 14px; color: #475569;">Manage your children's vaccination appointments with real-time status tracking and doctor connectivity.</p>
    </div>

    <!-- ── Dynamic Bootstrap Grid ── -->
    <div class="row g-4">
        @forelse($appointments as $appointment)
            @php
                // Real-time appointment check logic
                $isDoctorOnline = $appointment->doctor?->is_online ?? false;
                $isMeetingUnlocked = ($appointment->status === 'approved' && $isDoctorOnline);
                $hasPhone = ($appointment->doctor && $appointment->doctor->phone);
            @endphp
            
            <div class="col-md-6 col-xl-4">
                <article class="appt-card p-4 h-100 d-flex flex-column shadow-sm bg-white">
                    
                    <!-- 1. Header Profile Box (Child Name & Vaccine Badge) -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-ring">
                            <div class="avatar-inner">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h5 class="mb-1 fw-bold text-truncate text-capitalize" style="font-family: 'Space Grotesk', sans-serif; font-size: 17px; letter-spacing: -0.01em; color: #0f172a;">
                                {{ $appointment->child?->name ?? 'N/A' }}
                            </h5>
                            <div>
                                <span class="vaccine-pill">
                                    <i class="bi bi-shield-check-fill me-0.5"></i>
                                    {{ $appointment->vaccine?->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Subtle Horizontal Divider Grid Line -->
                    <div class="glow-divider"></div>

                    <!-- 2. Metadata Rows Block -->
                    <div class="d-flex flex-column gap-3 mb-4 flex-grow-1">
                        <!-- Hospital Item -->
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="info-label">
                                <i class="bi bi-building icon-hospital"></i>
                                <span>Hospital</span>
                            </div>
                            <div class="info-value text-truncate text-end text-secondary" style="max-width: 60%; color: #334155;" title="{{ $appointment->hospital?->name ?? 'N/A' }}">
                                {{ $appointment->hospital?->name ?? 'N/A' }}
                            </div>
                        </div>

                        <!-- Doctor Item -->
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="info-label">
                                <i class="bi bi-person-badge icon-doctor"></i>
                                <span>Doctor</span>
                            </div>
                            <div class="info-value text-truncate text-end" style="max-width: 60%; color: #4338ca;">
                                {{ $appointment->doctor?->name ?? 'Not Assigned Yet' }}
                            </div>
                        </div>

                        <!-- Clinic Real-time Status Item -->
                        <div class="d-flex align-items-center justify-content-between gap-2">
                            <div class="info-label">
                                <i class="bi bi-activity icon-status {{ $appointment->status !== 'approved' ? 'pending' : '' }}"></i>
                                <span>Status</span>
                            </div>
                            <div>
                                @if($appointment->status === 'approved')
                                    <span class="status-badge status-approved">
                                        <i class="bi bi-check-circle-fill" style="font-size: 10px;"></i>
                                        Approved
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <span class="pulse-dot"></span>
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 3. Actions Button Grid Footer Row -->
                    <div class="row g-2 mt-auto pt-2">
                        <!-- Left Action Column: WhatsApp Chat System Link -->
                        <div class="col-6">
                            @if($hasPhone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $appointment->doctor->phone) }}?text=Hello%20Dr.%20{{ urlencode($appointment->doctor->name) }},%20I%20have%20an%20appointment%20for%20my%20child."
                                    target="_blank"
                                    class="btn-action btn-chat w-100">
                                    <i class="bi bi-whatsapp" style="font-size: 15px;"></i>
                                    <span>Chat</span>
                                </a>
                            @else
                                <button class="btn-action btn-locked w-100" disabled title="Doctor WhatsApp number unavailable">
                                    <span class="lock-shimmer"></span>
                                    <i class="bi bi-lock-fill" style="font-size: 12px;"></i>
                                    <span>Chat</span>
                                </button>
                            @endif
                        </div>

                        <!-- Right Action Column: Live Video Virtual Room Access -->
                        <div class="col-6">
                            @if($isMeetingUnlocked)
                                <a href="{{ route('parent.meeting.join', $appointment->id) }}" class="btn-action btn-join w-100">
                                    <i class="bi bi-camera-video-fill" style="font-size: 14px;"></i>
                                    <span>Join Room</span>
                                </a>
                            @else
                                <button class="btn-action btn-locked w-100" disabled 
                                    title="{{ $appointment->status === 'pending' ? 'Waiting for admin approval' : 'Doctor is offline right now' }}">
                                    <span class="lock-shimmer"></span>
                                    <i class="bi bi-lock-fill" style="font-size: 12px;"></i>
                                    <span>Join Room</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </article>
            </div>
        @empty
            <div class="col-12 text-center py-5 rounded-4 appt-card bg-white shadow-sm">
                <i class="bi bi-calendar2-x d-block text-secondary mb-3" style="font-size: 3rem;"></i>
                <h5 class="fw-bold text-slate-800 mb-1">No Appointments Found</h5>
                <p class="small text-muted mb-0">You don't have any active pending or approved vaccination requests right now.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection