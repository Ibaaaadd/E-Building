{{--
    Stat Card Include
    Variables: $title, $value, $icon (FA class), $color (blue|green|purple|orange), $href
--}}
@php
$colors = [
    'blue'   => ['bg' => '#eff6ff', 'icon' => '#3b82f6', 'border' => '#bfdbfe'],
    'green'  => ['bg' => '#f0fdf4', 'icon' => '#22c55e', 'border' => '#bbf7d0'],
    'purple' => ['bg' => '#faf5ff', 'icon' => '#a855f7', 'border' => '#e9d5ff'],
    'orange' => ['bg' => '#fff7ed', 'icon' => '#f97316', 'border' => '#fed7aa'],
];
$c = $colors[$color ?? 'blue'] ?? $colors['blue'];
@endphp
<div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ ($delay ?? 0) * 80 }}">
    <a href="{{ $href ?? '#' }}" class="text-decoration-none">
        <div class="stat-card-item">
            <div class="stat-card-icon" style="background:{{ $c['bg'] }};border:1px solid {{ $c['border'] }}">
                <i class="{{ $icon ?? 'fas fa-chart-bar' }}" style="color:{{ $c['icon'] }}"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-value">{{ $value ?? 0 }}</div>
                <div class="stat-card-title">{{ $title ?? '' }}</div>
            </div>
        </div>
    </a>
</div>
