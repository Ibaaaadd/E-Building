@extends('layouts.main')

@section('page-title', 'Detail Laporan')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => $details->isNotEmpty() ? $details->first()->pelaporan->dinas->nama_dinas : 'Detail Laporan',
    'subtitle' => 'Daftar bidang penilaian',
    'actions'  => '<a href="' . route('pelaporan.index') . '" class="btn btn-secondary me-2"><i class="fas fa-arrow-left me-1"></i>Kembali</a>'
        . (Auth::user()->role_id == 2
            ? '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDetailModal"><i class="fas fa-plus me-1"></i>Tambah Bidang</button>'
            : ''),
])

{{-- Summary strip --}}
@php
    $total     = $details->count();
    $menunggu  = $details->where('status', 0)->count();
    $survey    = $details->where('status', 1)->count();
    $pengerjaan= $details->where('status', 2)->count();
    $selesai   = $details->where('status', 3)->count();
    $ditolak   = $details->where('status', -1)->count();
@endphp
<div class="row g-3 mb-4" data-aos="fade-up">
    @foreach([
        ['label'=>'Total','val'=>$total,      'icon'=>'fas fa-layer-group','color'=>'#6366f1','bg'=>'#eef2ff'],
        ['label'=>'Menunggu','val'=>$menunggu,'icon'=>'fas fa-clock',       'color'=>'#64748b','bg'=>'#f1f5f9'],
        ['label'=>'Survey','val'=>$survey,    'icon'=>'fas fa-search',      'color'=>'#f59e0b','bg'=>'#fffbeb'],
        ['label'=>'Pengerjaan','val'=>$pengerjaan,'icon'=>'fas fa-tools',   'color'=>'#3b82f6','bg'=>'#eff6ff'],
        ['label'=>'Selesai','val'=>$selesai,  'icon'=>'fas fa-check-circle','color'=>'#22c55e','bg'=>'#f0fdf4'],
        ['label'=>'Ditolak','val'=>$ditolak,  'icon'=>'fas fa-times-circle','color'=>'#ef4444','bg'=>'#fef2f2'],
    ] as $s)
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card text-center" style="border:none;background:{{ $s['bg'] }};">
            <div class="card-body" style="padding:14px 8px;">
                <div style="font-size:20px;color:{{ $s['color'] }};margin-bottom:4px;"><i class="{{ $s['icon'] }}"></i></div>
                <div style="font-size:22px;font-weight:700;color:{{ $s['color'] }};">{{ $s['val'] }}</div>
                <div style="font-size:11px;color:#64748b;font-weight:500;">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter chips --}}
<div class="d-flex gap-2 flex-wrap mb-4" data-aos="fade-up" id="filter-chips">
    <button class="filter-chip active" data-filter="all">Semua <span class="chip-count">{{ $total }}</span></button>
    <button class="filter-chip" data-filter="0">Menunggu <span class="chip-count">{{ $menunggu }}</span></button>
    <button class="filter-chip" data-filter="1">Survey <span class="chip-count">{{ $survey }}</span></button>
    <button class="filter-chip" data-filter="2">Pengerjaan <span class="chip-count">{{ $pengerjaan }}</span></button>
    <button class="filter-chip" data-filter="3">Selesai <span class="chip-count">{{ $selesai }}</span></button>
    @if($ditolak > 0)
    <button class="filter-chip" data-filter="-1">Ditolak <span class="chip-count">{{ $ditolak }}</span></button>
    @endif
</div>

{{-- Bidang Cards --}}
<div id="bidang-grid" class="row g-3" data-aos="fade-up">
    @foreach ($details as $d)
    @php
        $statusMap = [
            -1 => ['label'=>'Ditolak',         'color'=>'#ef4444','bg'=>'#fef2f2','icon'=>'fas fa-times-circle'],
             0 => ['label'=>'Menunggu Survey',  'color'=>'#64748b','bg'=>'#f1f5f9','icon'=>'fas fa-clock'],
             1 => ['label'=>'Survey',           'color'=>'#f59e0b','bg'=>'#fffbeb','icon'=>'fas fa-search'],
             2 => ['label'=>'Pengerjaan',       'color'=>'#3b82f6','bg'=>'#eff6ff','icon'=>'fas fa-tools'],
             3 => ['label'=>'Selesai',          'color'=>'#22c55e','bg'=>'#f0fdf4','icon'=>'fas fa-check-circle'],
        ];
        $st = $statusMap[$d->status] ?? $statusMap[0];
    @endphp
    <div class="bidang-card-col col-xl-4 col-md-6" data-status="{{ $d->status }}">
        <div class="card h-100" style="border-radius:14px;border-left:4px solid {{ $st['color'] }};transition:box-shadow .2s;"
            onmouseenter="this.style.boxShadow='0 8px 32px rgba(0,0,0,.1)'" onmouseleave="this.style.boxShadow=''">

            {{-- Card Header --}}
            <div class="card-body" style="padding:18px 20px 14px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="fw-bold" style="font-size:16px;margin-bottom:3px;">{{ $d->bidang }}</div>
                        <div style="font-size:12.5px;color:#64748b;">
                            <i class="fas fa-user me-1"></i>{{ $d->user->name }}
                        </div>
                    </div>
                    <span style="background:{{ $st['bg'] }};color:{{ $st['color'] }};font-size:11.5px;font-weight:600;padding:4px 12px;border-radius:20px;white-space:nowrap;">
                        <i class="{{ $st['icon'] }} me-1"></i>{{ $st['label'] }}
                    </span>
                </div>

                {{-- Progress stepper --}}
                <div class="d-flex align-items-center gap-1 mb-3" style="font-size:10px;">
                    @foreach([
                        [0,'Menunggu','#94a3b8'],
                        [1,'Survey','#f59e0b'],
                        [2,'Pengerjaan','#3b82f6'],
                        [3,'Selesai','#22c55e'],
                    ] as [$sv,$sl,$sc])
                    <div style="flex:1;text-align:center;">
                        <div style="height:4px;border-radius:2px;background:{{ ($d->status >= $sv && $d->status != -1) ? $sc : '#e2e8f0' }};margin-bottom:3px;"></div>
                        <span style="color:{{ ($d->status >= $sv && $d->status != -1) ? $sc : '#cbd5e1' }};font-weight:500;">{{ $sl }}</span>
                    </div>
                    @if($sv < 3)<div style="width:8px;height:4px;"></div>@endif
                    @endforeach
                </div>

                <div style="font-size:11.5px;color:#94a3b8;">
                    <i class="fas fa-clock me-1"></i>Update: {{ $d->updated_at->format('d M Y') }}
                </div>
            </div>

            {{-- Footer --}}
            <div class="card-footer bg-transparent" style="padding:10px 20px;border-top:1px solid #f1f5f9;">
                <form id="formDelete{{ $d->id }}" action="{{ route('detail.destroy', $d->id) }}" method="POST" style="display:none;">
                    @csrf @method('DELETE')
                </form>

                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    {{-- Left: always visible --}}
                    <div class="d-flex gap-2">
                        {{-- Riwayat --}}
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal" data-bs-target="#logModal{{ $d->id }}" title="Riwayat Status">
                            <i class="fas fa-history me-1"></i>Riwayat
                        </button>
                        {{-- Detail Penilaian --}}
                        <a href="{{ route('penilaian.detail', $d->id) }}"
                            class="btn btn-sm btn-outline-primary" title="Detail Penilaian">
                            <i class="fas fa-chart-bar me-1"></i>Penilaian
                        </a>
                    </div>

                    {{-- Right: role-based --}}
                    <div class="d-flex gap-1">
                        {{-- Role 2 (Admin): edit & delete jika bukan survey --}}
                        @if (Auth::user()->role_id == 2 && $d->status != 1)
                        <button type="button" class="btn-icon btn-icon-edit"
                            data-bs-toggle="modal" data-bs-target="#editDetailModal-{{ $d->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn-icon btn-icon-delete"
                            onclick="confirmDelete('{{ $d->id }}')" title="Hapus">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        @endif

                        {{-- Role 3: mulai survey jika menunggu --}}
                        @if (Auth::user()->role_id == 3 && $d->status == 0)
                        <form action="{{ route('detail.updateStatus', $d->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" name="status" value="1"
                                class="btn btn-sm btn-warning text-white" title="Mulai Survey">
                                <i class="fas fa-clipboard-check me-1"></i>Mulai Survey
                            </button>
                        </form>
                        @endif

                        {{-- Role 3: selesaikan jika pengerjaan --}}
                        @if (Auth::user()->role_id == 3 && $d->status == 2)
                        <form action="{{ route('detail.updateStatus', $d->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" name="status" value="3"
                                class="btn btn-sm btn-success" title="Selesaikan">
                                <i class="fas fa-flag-checkered me-1"></i>Selesai
                            </button>
                        </form>
                        @endif

                        {{-- Role 4: approve/tolak jika survey --}}
                        @if (Auth::user()->role_id == 4 && $d->status == 1)
                        <form action="{{ route('detail.updateStatus', $d->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" name="status" value="2"
                                class="btn btn-sm btn-success" title="Setujui">
                                <i class="fas fa-check me-1"></i>Setujui
                            </button>
                        </form>
                        <form action="{{ route('detail.updateStatus', $d->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" name="status" value="-1"
                                class="btn btn-sm btn-danger" title="Tolak">
                                <i class="fas fa-times me-1"></i>Tolak
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- No results --}}
<div id="no-results" style="display:none;" class="text-center py-5">
    <div style="font-size:48px;margin-bottom:12px;">📋</div>
    <div class="fw-semibold" style="color:#64748b;">Tidak ada bidang dengan status ini</div>
</div>

{{-- Add Bidang Modal --}}
@if (Auth::user()->role_id == 2)
<x-app-modal id="newDetailModal" title="Tambah Bidang" icon="fas fa-plus">
    <form method="POST" action="{{ route('detail.store', $id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="bidang">Nama Bidang</label>
            <input type="text" class="form-control" id="bidang" name="bidang" required placeholder="Masukkan nama bidang">
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</x-app-modal>
@endif

{{-- Edit Bidang Modals --}}
@foreach ($details as $d)
<x-app-modal id="editDetailModal-{{ $d->id }}" title="Edit Bidang" icon="fas fa-edit">
    <form method="POST" action="{{ route('detail.update', $d->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama Bidang</label>
            <input type="text" class="form-control" name="bidang" value="{{ $d->bidang }}" required>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</x-app-modal>
@endforeach

{{-- Riwayat Status Modals --}}
@foreach ($details as $d)
<div class="modal fade" id="logModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                <h5 class="modal-title fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Riwayat — {{ $d->bidang }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <div class="d-flex flex-column gap-3">
                    @if ($d->status >= 0 && $d->user)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-clock" style="color:#64748b;font-size:13px;"></i></div>
                        <div><div class="fw-semibold" style="font-size:13px;">{{ $d->user->name }}</div><div style="font-size:11.5px;color:#64748b;">Menunggu Survey &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d M Y H:i') }} WIB</div></div>
                    </div>
                    @endif
                    @if ($d->status >= 1 && $d->surveyUser)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#fffbeb;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-search" style="color:#f59e0b;font-size:13px;"></i></div>
                        <div><div class="fw-semibold" style="font-size:13px;">{{ $d->surveyUser->name }}</div><div style="font-size:11.5px;color:#64748b;">Survey &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($d->survey_at)->translatedFormat('d M Y H:i') }} WIB</div></div>
                    </div>
                    @endif
                    @if ($d->status >= 2 && $d->accUser)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-tools" style="color:#3b82f6;font-size:13px;"></i></div>
                        <div><div class="fw-semibold" style="font-size:13px;">{{ $d->accUser->name }}</div><div style="font-size:11.5px;color:#64748b;">Pengerjaan &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($d->acc_at)->translatedFormat('d M Y H:i') }} WIB</div></div>
                    </div>
                    @endif
                    @if ($d->status >= 3 && $d->selesaiUser)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-check-circle" style="color:#22c55e;font-size:13px;"></i></div>
                        <div><div class="fw-semibold" style="font-size:13px;">{{ $d->selesaiUser->name }}</div><div style="font-size:11.5px;color:#64748b;">Selesai &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($d->selesai_at)->translatedFormat('d M Y H:i') }} WIB</div></div>
                    </div>
                    @endif
                    @if ($d->status == -1 && $d->tolakUser)
                    <div class="d-flex gap-3 align-items-start">
                        <div style="width:32px;height:32px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-times-circle" style="color:#ef4444;font-size:13px;"></i></div>
                        <div><div class="fw-semibold" style="font-size:13px;">{{ $d->tolakUser->name }}</div><div style="font-size:11.5px;color:#64748b;">Ditolak &nbsp;·&nbsp; {{ \Carbon\Carbon::parse($d->tolak_at)->translatedFormat('d M Y H:i') }} WIB</div></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fafc;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
.filter-chip {
    padding: 5px 14px;
    border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    font-size: 12.5px;
    font-weight: 500;
    color: #64748b;
    cursor: pointer;
    transition: all .15s;
}
.filter-chip:hover { border-color: var(--accent,#f97316); color: var(--accent,#f97316); }
.filter-chip.active { background: var(--accent,#f97316); border-color: var(--accent,#f97316); color: #fff; }
.chip-count { display:inline-block; background:rgba(255,255,255,.25); border-radius:10px; padding:0 6px; font-size:11px; margin-left:4px; }
.filter-chip:not(.active) .chip-count { background:#f1f5f9; color:#64748b; }
</style>

<script>
document.querySelectorAll('.filter-chip').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        var filter = this.dataset.filter;
        var cards = document.querySelectorAll('.bidang-card-col');
        var shown = 0;
        cards.forEach(function(c) {
            var show = (filter === 'all') || (c.dataset.status === filter);
            c.style.display = show ? '' : 'none';
            if (show) shown++;
        });
        document.getElementById('no-results').style.display = (shown === 0) ? '' : 'none';
    });
});

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Bidang?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) document.getElementById('formDelete' + id).submit();
    });
}
</script>

@endsection
