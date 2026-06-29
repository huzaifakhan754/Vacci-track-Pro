@props([
    'title',
    'value',
    'icon',
    'iconBg' => '#D1FAE5',
    'iconColor' => '#10B981',
    'sparkColor' => '#10B981',
    'trend' => null,
    'trendUp' => true,
])

<div class="apex-card h-100">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <p class="text-muted mb-1" style="font-size:13px;">{{ $title }}</p>
            <h3 class="fw-bold mb-0" style="font-size:28px;color:#111827;">{{ $value }}</h3>
            @if ($trend)
                <span class="small fw-medium {{ $trendUp ? 'text-success' : 'text-danger' }}">{{ $trend }}</span>
            @endif
        </div>
        <div class="apex-kpi-icon" style="background:{{ $iconBg }};color:{{ $iconColor }};">
            <i class="bi {{ $icon }}"></i>
        </div>
    </div>
    <svg class="apex-sparkline w-100" viewBox="0 0 120 40" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,28 C15,8 30,32 45,18 S75,6 90,22 105,12 120,20" fill="none" stroke="{{ $sparkColor }}" stroke-width="2" stroke-linecap="round"/>
    </svg>
</div>
