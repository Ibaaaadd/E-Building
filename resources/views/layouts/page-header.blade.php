{{--
    Page Header Include
    Variables: $title, $subtitle (optional), $actions (optional HTML string)
--}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4" data-aos="fade-down">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:#0f172a;margin:0;">{{ $title ?? 'Page' }}</h1>
        @if(!empty($subtitle))
            <p style="font-size:13px;color:#94a3b8;margin:4px 0 0;">{{ $subtitle }}</p>
        @endif
    </div>
    @if(!empty($actions))
        <div>{!! $actions !!}</div>
    @endif
</div>
