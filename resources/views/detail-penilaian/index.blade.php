<!-- resources/views/detail_penilaian/index.blade.php -->

@extends('layouts.main')

@section('page-title', 'Detail Penilaian')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

<style>
.penilaian-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8edf5;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.penilaian-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
    transform: translateY(-2px);
}
.penilaian-card-header {
    padding: 14px 18px 10px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
}
.penilaian-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.4;
    flex: 1;
}
.penilaian-card-surveyor {
    font-size: 12px;
    color: #64748b;
    margin-top: 3px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.penilaian-card-body {
    padding: 14px 18px;
}
.photo-phases {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 14px;
}
.photo-phase {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}
.photo-phase-label {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #94a3b8;
}
.photo-phase-img {
    width: 100%;
    aspect-ratio: 1;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    cursor: pointer;
    transition: border-color .15s, transform .15s;
}
.photo-phase-img:hover {
    border-color: #6366f1;
    transform: scale(1.03);
}
.photo-phase-empty {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 10px;
    border: 2px dashed #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
    font-size: 22px;
}
.nilai-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 14px;
}
.nilai-box {
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px 10px;
    text-align: center;
}
.nilai-box-label {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #94a3b8;
    margin-bottom: 4px;
}
.nilai-stars { font-size: 13px; letter-spacing: 1px; }
.nilai-stars .empty { color: #e2e8f0; }
.penilaian-card-footer {
    padding: 10px 18px 14px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.penilaian-empty {
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}
.penilaian-empty i { font-size: 48px; margin-bottom: 14px; display: block; }
</style>

@include('layouts.page-header', [
    'title'    => 'Detail Penilaian',
    'subtitle' => 'Rincian penilaian indikator bangunan',
    'actions'  => Auth::user()->role_id == 2 && $dtl->detail_penilaian->count() < $jumlahindikator
        ? '<a href="' . route('penilaian.index', $dtl->id) . '" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah Nilai</a>'
        : '',
])

{{-- Summary strip --}}
<div class="card mb-4" data-aos="fade-up">
    <div class="card-body py-3">
        <div class="d-flex flex-wrap gap-4 align-items-center">
            <div>
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;">Total Indikator</div>
                <div style="font-size:20px;font-weight:700;color:#0f172a;">{{ $detailPenilaians->count() }} <span style="font-size:13px;color:#94a3b8;">/ {{ $jumlahindikator }}</span></div>
            </div>
            <div style="width:1px;height:36px;background:#e8edf5;"></div>
            <div>
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;">Selesai Dinilai</div>
                <div style="font-size:20px;font-weight:700;color:#16a34a;">{{ $detailPenilaians->where('nilai_sesudah', '>', 0)->count() }}</div>
            </div>
            <div style="width:1px;height:36px;background:#e8edf5;"></div>
            <div>
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;">Menunggu Survey</div>
                <div style="font-size:20px;font-weight:700;color:#f59e0b;">{{ $detailPenilaians->where('nilai_survey', 0)->count() }}</div>
            </div>
        </div>
    </div>
</div>

@if ($detailPenilaians->isEmpty())
    <div class="card" data-aos="fade-up">
        <div class="card-body penilaian-empty">
            <i class="fas fa-clipboard-list"></i>
            <p class="fw-semibold mb-1">Belum ada data penilaian</p>
            <p style="font-size:13px;">Klik tombol "Tambah Nilai" untuk memulai penilaian indikator.</p>
        </div>
    </div>
@else

{{-- Filter Bar --}}
<div class="penilaian-filter-bar mb-3" data-aos="fade-up">
    <div class="penilaian-filter-chips">
        <button class="filter-chip active" data-filter="all">
            <i class="fas fa-th-large"></i> Semua
            <span class="filter-count">{{ $detailPenilaians->count() }}</span>
        </button>
        <button class="filter-chip" data-filter="baru">
            <i class="fas fa-circle" style="color:#94a3b8;font-size:8px;"></i> Baru
            <span class="filter-count">{{ $detailPenilaians->filter(fn($d) => !$d->nilai_indikator)->count() }}</span>
        </button>
        <button class="filter-chip" data-filter="dinilai">
            <i class="fas fa-star" style="color:#f59e0b;font-size:10px;"></i> Dinilai
            <span class="filter-count">{{ $detailPenilaians->filter(fn($d) => $d->nilai_indikator > 0 && !$d->nilai_survey)->count() }}</span>
        </button>
        <button class="filter-chip" data-filter="survey">
            <i class="fas fa-search" style="color:#0ea5e9;font-size:10px;"></i> Survey
            <span class="filter-count">{{ $detailPenilaians->filter(fn($d) => $d->nilai_survey > 0 && !$d->nilai_sesudah)->count() }}</span>
        </button>
        <button class="filter-chip" data-filter="selesai">
            <i class="fas fa-check-circle" style="color:#16a34a;font-size:10px;"></i> Selesai
            <span class="filter-count">{{ $detailPenilaians->where('nilai_sesudah', '>', 0)->count() }}</span>
        </button>
    </div>
    <div class="penilaian-filter-search">
        <i class="fas fa-search"></i>
        <input type="text" id="penilaian-search" placeholder="Cari indikator…">
    </div>
</div>

<style>
.penilaian-filter-bar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
}
.penilaian-filter-chips { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 999px;
    border: 1.5px solid #e2e8f0; background: #fff;
    font-size: 12.5px; font-weight: 500; color: #64748b;
    cursor: pointer; transition: all .15s; white-space: nowrap;
}
.filter-chip:hover { border-color: #f97316; color: #f97316; background: #fff7ed; }
.filter-chip.active { border-color: #f97316; background: #fff7ed; color: #ea6c00; font-weight: 600; }
.filter-count {
    background: #f1f5f9; color: #64748b;
    font-size: 11px; font-weight: 700;
    padding: 1px 6px; border-radius: 999px; min-width: 20px; text-align: center;
}
.filter-chip.active .filter-count { background: #fed7aa; color: #c2410c; }
.penilaian-filter-search {
    position: relative; display: flex; align-items: center;
}
.penilaian-filter-search i {
    position: absolute; left: 11px; color: #94a3b8; font-size: 13px; pointer-events: none;
}
#penilaian-search {
    border: 1.5px solid #e2e8f0; border-radius: 999px;
    padding: 7px 14px 7px 32px; font-size: 13px; color: #374151;
    width: 210px; outline: none; font-family: 'Inter', sans-serif;
    transition: border-color .15s, box-shadow .15s;
}
#penilaian-search:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,.12); }
#penilaian-search::placeholder { color: #c0cad8; }
.penilaian-card-col { transition: opacity .2s; }
.penilaian-card-col.hidden { display: none !important; }
.no-results-msg {
    text-align:center; padding: 48px 20px; color: #94a3b8;
    font-size: 14px; width: 100%;
}
.no-results-msg i { font-size: 36px; display: block; margin-bottom: 10px; }
</style>

    <div class="row g-3" id="penilaian-grid" data-aos="fade-up">
        @foreach ($detailPenilaians as $detail)
        @php
            $filterStatus = match(true) {
                $detail->nilai_sesudah > 0   => 'selesai',
                $detail->nilai_survey > 0    => 'survey',
                $detail->nilai_indikator > 0 => 'dinilai',
                default                      => 'baru',
            };
        @endphp
        <div class="col-12 col-md-6 col-xl-4 penilaian-card-col"
             data-status="{{ $filterStatus }}"
             data-name="{{ strtolower($detail->indikator->nama_indikator) }}">
            <div class="penilaian-card h-100">

                {{-- Header --}}
                <div class="penilaian-card-header">
                    <div>
                        <div class="penilaian-card-title">{{ $detail->indikator->nama_indikator }}</div>
                        <div class="penilaian-card-surveyor">
                            <i class="fas fa-user-circle"></i>
                            {{ $detail->id_surveyor ? $detail->user->name : 'Belum ada surveyor' }}
                        </div>
                    </div>
                    @php
                        $statusInfo = match(true) {
                            $detail->nilai_sesudah > 0  => ['Selesai',  'text-bg-success'],
                            $detail->nilai_survey > 0   => ['Survey',   'text-bg-info'],
                            $detail->nilai_indikator > 0 => ['Dinilai', 'text-bg-warning'],
                            default                     => ['Baru',     'text-bg-secondary'],
                        };
                    @endphp
                    <span class="badge {{ $statusInfo[1] }}" style="font-size:11px;white-space:nowrap;">{{ $statusInfo[0] }}</span>
                </div>

                <div class="penilaian-card-body">

                    {{-- Nilai bintang --}}
                    <div class="nilai-row">
                        @foreach ([
                            ['label' => 'Indikator', 'nilai' => $detail->nilai_indikator],
                            ['label' => 'Survey',    'nilai' => $detail->nilai_survey],
                            ['label' => 'Sesudah',   'nilai' => $detail->nilai_sesudah],
                        ] as $n)
                        <div class="nilai-box">
                            <div class="nilai-box-label">{{ $n['label'] }}</div>
                            <div class="nilai-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $n['nilai'] ? 'text-warning' : 'empty' }}"></i>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Foto 3 fase --}}
                    <div class="photo-phases">
                        @foreach ([
                            ['label' => 'Sebelum', 'foto' => $detail->gambar_sebelum, 'target' => '#gambarSebelum'.$detail->id],
                            ['label' => 'Survey',  'foto' => $detail->gambar_survey,  'target' => '#gambarSurvey'.$detail->id],
                            ['label' => 'Sesudah', 'foto' => $detail->gambar_sesudah, 'target' => '#gambarSesudah'.$detail->id],
                        ] as $foto)
                        <div class="photo-phase">
                            <div class="photo-phase-label">{{ $foto['label'] }}</div>
                            @if ($foto['foto'])
                                <img class="photo-phase-img"
                                    src="{{ asset('fotoDetail/' . $foto['foto']) }}"
                                    alt="{{ $foto['label'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="{{ $foto['target'] }}">
                            @else
                                <div class="photo-phase-empty"><i class="fas fa-image"></i></div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- Footer — tombol sesuai role --}}
                @php $hasFooter =
                    (Auth::user()->role_id == 2 && $dtl->status != 4) ||
                    Auth::user()->role_id == 3;
                @endphp
                @if ($hasFooter)
                <div class="penilaian-card-footer">
                    {{-- Role 2 (Admin): edit foto sebelum --}}
                    @if (Auth::user()->role_id == 2 && $dtl->status != 4)
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#detailSebelum{{ $detail->id }}">
                            <i class="fas fa-image me-1"></i>Edit Foto Sebelum
                        </button>
                    @endif

                    {{-- Role 3 (Surveyor): isi survey & sesudah --}}
                    @if (Auth::user()->role_id == 3)
                        <button type="button" class="btn btn-sm btn-outline-info"
                            data-bs-toggle="modal" data-bs-target="#detailSurvey{{ $detail->id }}">
                            <i class="fas fa-search me-1"></i>Isi Survey
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success"
                            data-bs-toggle="modal" data-bs-target="#detailSesudah{{ $detail->id }}">
                            <i class="fas fa-check-circle me-1"></i>Isi Sesudah
                        </button>
                    @endif
                </div>
                @endif

            </div>
        </div>
        @endforeach
        <div class="no-results-msg" id="penilaian-no-results" style="display:none;">
            <i class="fas fa-search"></i>
            Tidak ada indikator yang cocok dengan filter ini.
        </div>
    </div>
@endif

<script>
(function () {
    const chips  = document.querySelectorAll('.filter-chip');
    const cards  = document.querySelectorAll('.penilaian-card-col');
    const search = document.getElementById('penilaian-search');
    const noRes  = document.getElementById('penilaian-no-results');
    let activeFilter = 'all';
    let searchVal    = '';

    function applyFilter() {
        let visible = 0;
        cards.forEach(card => {
            const matchFilter = activeFilter === 'all' || card.dataset.status === activeFilter;
            const matchSearch = !searchVal || card.dataset.name.includes(searchVal);
            const show = matchFilter && matchSearch;
            card.classList.toggle('hidden', !show);
            if (show) visible++;
        });
        if (noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
    }

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            chips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeFilter = chip.dataset.filter;
            applyFilter();
        });
    });

    if (search) {
        search.addEventListener('input', () => {
            searchVal = search.value.trim().toLowerCase();
            applyFilter();
        });
    }
})();
</script>

{{-- ===== MODALS ===== --}}

{{-- Foto lightbox modals --}}
@foreach ($detailPenilaians as $detail)
    @if ($detail->gambar_sebelum)
        <x-photo-modal id="gambarSebelum{{ $detail->id }}" title="Foto Sebelum — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_sebelum) }}" />
    @endif
    @if ($detail->gambar_survey)
        <x-photo-modal id="gambarSurvey{{ $detail->id }}" title="Foto Survey — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_survey) }}" />
    @endif
    @if ($detail->gambar_sesudah)
        <x-photo-modal id="gambarSesudah{{ $detail->id }}" title="Foto Sesudah — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_sesudah) }}" />
    @endif
@endforeach

{{-- Edit modals --}}
@foreach ($detailPenilaians as $detail)

{{-- ── MODAL: Edit Foto Sebelum (Role 2) ── --}}
<div class="modal fade penilaian-modal" id="detailSebelum{{ $detail->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content penilaian-modal-content">
            <div class="penilaian-modal-header" style="--accent:#6366f1;--accent-light:#ede9fe;">
                <div class="penilaian-modal-icon" style="background:var(--accent-light);">
                    <i class="fas fa-camera" style="color:var(--accent);"></i>
                </div>
                <div class="penilaian-modal-meta">
                    <div class="penilaian-modal-title">Edit Foto Sebelum</div>
                    <div class="penilaian-modal-sub">{{ $detail->indikator->nama_indikator }}</div>
                </div>
                <button type="button" class="penilaian-modal-close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="penilaian-modal-body">
                <form action="{{ route('detailPenilaian.ganti', $detail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @if ($detail->gambar_sebelum)
                    <div class="penilaian-current-photo">
                        <div class="penilaian-current-label"><i class="fas fa-image me-1"></i>Foto saat ini</div>
                        <img src="{{ asset('fotoDetail/' . $detail->gambar_sebelum) }}" alt="Foto Sebelum">
                    </div>
                    @endif
                    <div class="penilaian-upload-zone" data-accent="#6366f1" onclick="this.querySelector('input').click()">
                        <input type="file" name="gambar_sebelum" accept="image/*" required style="display:none;" onchange="previewUpload(this)">
                        <div class="penilaian-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="penilaian-upload-text">Klik untuk pilih foto</div>
                        <div class="penilaian-upload-hint">JPG, PNG, WEBP — maks 2MB</div>
                        <img class="penilaian-upload-preview" style="display:none;" alt="Preview">
                    </div>
                    <div class="penilaian-modal-footer">
                        <button type="button" class="btn-penilaian-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-penilaian-submit" style="--btn-color:#6366f1;">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL: Isi Survey (Role 3) ── --}}
<div class="modal fade penilaian-modal" id="detailSurvey{{ $detail->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content penilaian-modal-content">
            <div class="penilaian-modal-header" style="--accent:#f59e0b;--accent-light:#fef3c7;">
                <div class="penilaian-modal-icon" style="background:var(--accent-light);">
                    <i class="fas fa-search" style="color:var(--accent);"></i>
                </div>
                <div class="penilaian-modal-meta">
                    <div class="penilaian-modal-title">Isi Nilai Survey</div>
                    <div class="penilaian-modal-sub">{{ $detail->indikator->nama_indikator }}</div>
                </div>
                <button type="button" class="penilaian-modal-close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="penilaian-modal-body">
                <form action="{{ route('detailPenilaian.update', $detail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Star rating --}}
                    <div class="penilaian-star-section">
                        <div class="penilaian-star-label">Nilai Survey</div>
                        <div class="penilaian-star-picker" data-name="nilai_survey" data-selected="{{ $detail->nilai_survey }}">
                            @foreach([1=>'Tidak Layak',2=>'Rusak Berat',3=>'Rusak Sedang',4=>'Rusak Ringan',5=>'Layak'] as $val => $lbl)
                            <button type="button" class="star-btn" data-value="{{ $val }}" title="{{ $lbl }}">
                                <i class="fas fa-star"></i>
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="nilai_survey" class="star-hidden-input" value="{{ $detail->nilai_survey ?: '' }}">
                        <div class="penilaian-star-desc"></div>
                    </div>

                    {{-- Upload foto --}}
                    @if ($detail->gambar_survey)
                    <div class="penilaian-current-photo">
                        <div class="penilaian-current-label"><i class="fas fa-image me-1"></i>Foto survey saat ini</div>
                        <img src="{{ asset('fotoDetail/' . $detail->gambar_survey) }}" alt="Foto Survey">
                    </div>
                    @endif
                    <div class="penilaian-upload-zone" onclick="this.querySelector('input').click()">
                        <input type="file" name="gambar_survey" accept="image/*" style="display:none;" onchange="previewUpload(this)">
                        <div class="penilaian-upload-icon"><i class="fas fa-camera"></i></div>
                        <div class="penilaian-upload-text">Unggah foto survey <span style="color:#94a3b8;">(opsional)</span></div>
                        <div class="penilaian-upload-hint">JPG, PNG, WEBP</div>
                        <img class="penilaian-upload-preview" style="display:none;" alt="Preview">
                    </div>

                    <div class="penilaian-modal-footer">
                        <button type="button" class="btn-penilaian-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-penilaian-submit" style="--btn-color:#f59e0b;">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── MODAL: Isi Sesudah (Role 3) ── --}}
<div class="modal fade penilaian-modal" id="detailSesudah{{ $detail->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content penilaian-modal-content">
            <div class="penilaian-modal-header" style="--accent:#16a34a;--accent-light:#dcfce7;">
                <div class="penilaian-modal-icon" style="background:var(--accent-light);">
                    <i class="fas fa-check-circle" style="color:var(--accent);"></i>
                </div>
                <div class="penilaian-modal-meta">
                    <div class="penilaian-modal-title">Isi Nilai Sesudah</div>
                    <div class="penilaian-modal-sub">{{ $detail->indikator->nama_indikator }}</div>
                </div>
                <button type="button" class="penilaian-modal-close" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="penilaian-modal-body">
                <form action="{{ route('detailPenilaian.upload', $detail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Star rating --}}
                    <div class="penilaian-star-section">
                        <div class="penilaian-star-label">Nilai Sesudah</div>
                        <div class="penilaian-star-picker" data-name="nilai_sesudah" data-selected="{{ $detail->nilai_sesudah }}">
                            @foreach([1=>'Tidak Layak',2=>'Rusak Berat',3=>'Rusak Sedang',4=>'Rusak Ringan',5=>'Layak'] as $val => $lbl)
                            <button type="button" class="star-btn" data-value="{{ $val }}" title="{{ $lbl }}">
                                <i class="fas fa-star"></i>
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="nilai_sesudah" class="star-hidden-input" value="{{ $detail->nilai_sesudah ?: '' }}">
                        <div class="penilaian-star-desc"></div>
                    </div>

                    @if ($detail->gambar_sesudah)
                    <div class="penilaian-current-photo">
                        <div class="penilaian-current-label"><i class="fas fa-image me-1"></i>Foto sesudah saat ini</div>
                        <img src="{{ asset('fotoDetail/' . $detail->gambar_sesudah) }}" alt="Foto Sesudah">
                    </div>
                    @endif
                    <div class="penilaian-upload-zone" onclick="this.querySelector('input').click()">
                        <input type="file" name="gambar_sesudah" accept="image/*" style="display:none;" onchange="previewUpload(this)">
                        <div class="penilaian-upload-icon"><i class="fas fa-camera"></i></div>
                        <div class="penilaian-upload-text">Unggah foto sesudah <span style="color:#94a3b8;">(opsional)</span></div>
                        <div class="penilaian-upload-hint">JPG, PNG, WEBP</div>
                        <img class="penilaian-upload-preview" style="display:none;" alt="Preview">
                    </div>

                    <div class="penilaian-modal-footer">
                        <button type="button" class="btn-penilaian-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-penilaian-submit" style="--btn-color:#16a34a;">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach

<style>
/* ── Penilaian Modal Styles ── */
.penilaian-modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.18);
}
.penilaian-modal-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px 22px 18px;
    background: linear-gradient(135deg, var(--accent-light) 0%, #fff 70%);
    border-bottom: 1px solid rgba(0,0,0,.06);
}
.penilaian-modal-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.penilaian-modal-meta { flex: 1; min-width: 0; }
.penilaian-modal-title {
    font-size: 15px; font-weight: 700; color: #0f172a; line-height: 1.3;
}
.penilaian-modal-sub {
    font-size: 12px; color: #64748b; margin-top: 2px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.penilaian-modal-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: none; background: rgba(0,0,0,.06);
    color: #64748b; cursor: pointer; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
}
.penilaian-modal-close:hover { background: #fee2e2; color: #ef4444; }

.penilaian-modal-body { padding: 20px 22px 0; }

/* Current photo strip */
.penilaian-current-photo {
    background: #f8fafc; border-radius: 12px;
    padding: 10px 12px; margin-bottom: 14px;
    display: flex; align-items: center; gap: 12px;
}
.penilaian-current-label {
    font-size: 11px; font-weight: 600; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .5px;
    white-space: nowrap;
}
.penilaian-current-photo img {
    height: 52px; width: 52px; object-fit: cover;
    border-radius: 8px; border: 2px solid #e2e8f0;
    margin-left: auto;
}

/* Star picker */
.penilaian-star-section { margin-bottom: 18px; }
.penilaian-star-label {
    font-size: 12px; font-weight: 600; color: #374151;
    margin-bottom: 10px; text-transform: uppercase; letter-spacing: .5px;
}
.penilaian-star-picker {
    display: flex; gap: 6px; margin-bottom: 6px;
}
.star-btn {
    width: 46px; height: 46px; border-radius: 12px;
    border: 2px solid #e2e8f0; background: #f8fafc;
    color: #cbd5e1; font-size: 20px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; flex: 1;
}
.star-btn:hover, .star-btn.hovered { color: #fbbf24; border-color: #fde68a; background: #fffbeb; }
.star-btn.active { color: #f59e0b; border-color: #f59e0b; background: #fef3c7; transform: scale(1.08); }
.penilaian-star-desc {
    font-size: 12px; color: #6366f1; font-weight: 600;
    min-height: 18px; text-align: center; margin-top: 4px;
    transition: opacity .15s;
}

/* Upload zone */
.penilaian-upload-zone {
    border: 2px dashed #e2e8f0; border-radius: 14px;
    padding: 20px 16px; text-align: center; cursor: pointer;
    transition: border-color .15s, background .15s; margin-bottom: 0;
    background: #fafbfc;
}
.penilaian-upload-zone:hover { border-color: #a5b4fc; background: #f5f3ff; }
.penilaian-upload-zone.dragover { border-color: #6366f1; background: #ede9fe; }
.penilaian-upload-icon { font-size: 28px; color: #cbd5e1; margin-bottom: 6px; }
.penilaian-upload-text { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 3px; }
.penilaian-upload-hint { font-size: 11px; color: #94a3b8; }
.penilaian-upload-preview {
    max-height: 140px; border-radius: 10px;
    margin-top: 12px; object-fit: cover;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}

/* Footer */
.penilaian-modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 18px 0 20px;
}
.btn-penilaian-cancel {
    padding: 9px 20px; border-radius: 10px;
    border: 1.5px solid #e2e8f0; background: #fff;
    font-size: 13px; font-weight: 600; color: #64748b;
    cursor: pointer; transition: background .15s;
}
.btn-penilaian-cancel:hover { background: #f1f5f9; }
.btn-penilaian-submit {
    padding: 9px 22px; border-radius: 10px; border: none;
    background: var(--btn-color); color: #fff;
    font-size: 13px; font-weight: 600; cursor: pointer;
    transition: opacity .15s, transform .1s; box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.btn-penilaian-submit:hover { opacity: .88; transform: translateY(-1px); }
</style>

<script>
/* ── File upload preview ── */
function previewUpload(input) {
    const zone = input.closest('.penilaian-upload-zone');
    const preview = zone.querySelector('.penilaian-upload-preview');
    const icon    = zone.querySelector('.penilaian-upload-icon');
    const text    = zone.querySelector('.penilaian-upload-text');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            icon.style.display = 'none';
            text.textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* ── Star picker ── */
const starLabels = {1:'Tidak Layak',2:'Rusak Berat',3:'Rusak Sedang',4:'Rusak Ringan',5:'Layak'};
document.querySelectorAll('.penilaian-star-picker').forEach(picker => {
    const btns   = picker.querySelectorAll('.star-btn');
    const hidden = picker.parentElement.querySelector('.star-hidden-input');
    const desc   = picker.parentElement.querySelector('.penilaian-star-desc');
    let current  = parseInt(picker.dataset.selected) || 0;

    function render(val) {
        btns.forEach(b => {
            const v = parseInt(b.dataset.value);
            b.classList.toggle('active', v <= val);
            b.classList.remove('hovered');
        });
        desc.textContent = val ? starLabels[val] : '';
    }
    render(current);

    btns.forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            const v = parseInt(btn.dataset.value);
            btns.forEach(b => b.classList.toggle('hovered', parseInt(b.dataset.value) <= v));
        });
        picker.addEventListener('mouseleave', () => render(current));
        btn.addEventListener('click', () => {
            current = parseInt(btn.dataset.value);
            hidden.value = current;
            render(current);
        });
    });
});

/* ── Drag & drop upload ── */
document.querySelectorAll('.penilaian-upload-zone').forEach(zone => {
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
    zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
    zone.addEventListener('drop', e => {
        e.preventDefault(); zone.classList.remove('dragover');
        const input = zone.querySelector('input[type=file]');
        const dt = new DataTransfer();
        dt.items.add(e.dataTransfer.files[0]);
        input.files = dt.files;
        previewUpload(input);
    });
});
</script>

@endsection
