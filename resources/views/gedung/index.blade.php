@extends('layouts.main')

@section('page-title', 'Gedung')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Gedung',
    'subtitle' => 'Kelola data gedung',
    'actions'  => '<a href="' . route('gedung.create') . '" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Tambah</a>',
])

{{-- Filter Bar --}}
<div class="card mb-4" data-aos="fade-up">
    <div class="card-body" style="padding:16px 20px;">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari nama gedung atau alamat...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="filterDinas" class="form-select form-select-sm">
                    <option value="">Semua Dinas</option>
                    @foreach($gedungs->unique('id_dinas') as $g)
                        <option value="{{ $g->dinas->nama_dinas }}">{{ $g->dinas->nama_dinas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="filterJenis" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($gedungs->unique('id_jenis') as $g)
                        <option value="{{ $g->jenis->nama }}">{{ $g->jenis->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select id="perPageSelect" class="form-select form-select-sm">
                    <option value="6">6 per halaman</option>
                    <option value="9" selected>9 per halaman</option>
                    <option value="12">12 per halaman</option>
                    <option value="24">24 per halaman</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Stats strip --}}
<div id="results-info" class="mb-3" style="font-size:13px;color:#64748b;" data-aos="fade-up"></div>

{{-- Card Grid --}}
<div id="gedung-grid" class="row g-3" data-aos="fade-up" data-aos-delay="50">
    @foreach ($gedungs as $gedung)
    <div class="gedung-card-col col-xl-4 col-md-6"
        data-name="{{ strtolower($gedung->nama_gedung . ' ' . $gedung->alamat_gedung) }}"
        data-dinas="{{ $gedung->dinas->nama_dinas }}"
        data-jenis="{{ $gedung->jenis->nama }}">

        <div class="card h-100" style="border-radius:14px;overflow:hidden;transition:box-shadow .2s;" onmouseenter="this.style.boxShadow='0 8px 32px rgba(0,0,0,.12)'" onmouseleave="this.style.boxShadow=''">

            {{-- Photo Header --}}
            <div style="position:relative;height:180px;background:#f1f5f9;overflow:hidden;">
                <img src="{{ asset('fotoGedung/' . $gedung->foto_gedung) }}"
                    alt="{{ $gedung->nama_gedung }}"
                    style="width:100%;height:100%;object-fit:cover;"
                    onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%25%22 height=%22100%25%22><rect fill=%22%23f1f5f9%22 width=%22100%25%22 height=%22100%25%22/><text x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dominant-baseline=%22middle%22 fill=%22%2394a3b8%22 font-size=%2240%22>🏢</text></svg>'">
                {{-- Jenis badge --}}
                <span style="position:absolute;top:10px;left:10px;background:rgba(249,115,22,.9);color:#fff;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;">
                    {{ $gedung->jenis->nama }}
                </span>
                {{-- Photo view button --}}
                <button type="button" class="btn-icon btn-icon-info"
                    style="position:absolute;bottom:10px;right:10px;background:rgba(255,255,255,.9);"
                    data-bs-toggle="modal" data-bs-target="#modalFoto{{ $gedung->id }}" title="Lihat foto">
                    <i class="fas fa-expand-alt"></i>
                </button>
            </div>

            {{-- Body --}}
            <div class="card-body" style="padding:16px 18px 12px;">
                <div class="fw-bold" style="font-size:15px;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $gedung->nama_gedung }}">
                    {{ $gedung->nama_gedung }}
                </div>
                <div style="font-size:12.5px;color:#f97316;font-weight:600;margin-bottom:8px;">
                    <i class="fas fa-building me-1"></i>{{ $gedung->dinas->nama_dinas }}
                </div>
                @if($gedung->alamat_gedung)
                <div style="font-size:12px;color:#64748b;margin-bottom:10px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $gedung->alamat_gedung }}">
                    <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $gedung->alamat_gedung }}
                </div>
                @endif

                {{-- Luas info --}}
                <div class="d-flex gap-2 mb-3">
                    @if($gedung->luas_gedung)
                    <div style="flex:1;background:#f8fafc;border-radius:8px;padding:7px 10px;text-align:center;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:500;">Luas Gedung</div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $gedung->luas_gedung }} m²</div>
                    </div>
                    @endif
                    @if($gedung->luas_tanah)
                    <div style="flex:1;background:#f8fafc;border-radius:8px;padding:7px 10px;text-align:center;">
                        <div style="font-size:11px;color:#94a3b8;font-weight:500;">Luas Tanah</div>
                        <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ $gedung->luas_tanah }} m²</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="card-footer bg-transparent" style="padding:10px 18px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
                <button type="button" class="btn btn-sm btn-outline-secondary"
                    data-bs-toggle="modal" data-bs-target="#koordinatGedungModal-{{ $gedung->id }}">
                    <i class="fas fa-map-marker-alt me-1 text-danger"></i>Peta
                </button>
                <div class="d-flex gap-1">
                    <form id="formDelete{{ $gedung->id }}" action="{{ route('gedung.destroy', $gedung->id) }}" method="POST" style="display:none;">
                        @csrf @method('DELETE')
                    </form>
                    <a href="{{ route('gedung.edit', $gedung->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $gedung->id }}')" title="Hapus">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>

{{-- No results --}}
<div id="no-results" style="display:none;" class="text-center py-5">
    <div style="font-size:48px;margin-bottom:12px;">🏢</div>
    <div class="fw-semibold" style="color:#64748b;">Tidak ada gedung yang sesuai filter</div>
</div>

{{-- Pagination --}}
<div class="d-flex align-items-center justify-content-between mt-4 flex-wrap gap-2" id="pagination-wrap">
    <div id="page-info" style="font-size:13px;color:#64748b;"></div>
    <div id="pagination-btns" class="d-flex gap-1 flex-wrap"></div>
</div>

{{-- Foto Modals --}}
@foreach ($gedungs as $gedung)
<x-photo-modal id="modalFoto{{ $gedung->id }}" title="{{ $gedung->nama_gedung }}" src="{{ asset('fotoGedung/' . $gedung->foto_gedung) }}" />
@endforeach

{{-- Koordinat Modals --}}
@foreach ($gedungs as $gedung)
<div class="modal fade" id="koordinatGedungModal-{{ $gedung->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold"><i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $gedung->nama_gedung }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="border-radius:0 0 16px 16px;overflow:hidden;">
                <iframe width="100%" height="380" frameborder="0" scrolling="no"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.961377470213!2d{{ $gedung->longitude }}!3d{{ $gedung->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fc55a1e647d1%3A0x9efb96a99bcb6fd0!2s{{ $gedung->latitude }}%2C{{ $gedung->longitude }}!5e0!3m2!1sen!2sid!4v1618471972381!5m2!1sen!2sid">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
(function() {
    var cards = Array.from(document.querySelectorAll('.gedung-card-col'));
    var filtered = cards.slice();
    var perPage = 9, currentPage = 1;

    function applyFilters() {
        var search = document.getElementById('searchInput').value.toLowerCase();
        var dinas  = document.getElementById('filterDinas').value;
        var jenis  = document.getElementById('filterJenis').value;

        filtered = cards.filter(function(c) {
            var matchSearch = !search || c.dataset.name.includes(search);
            var matchDinas  = !dinas  || c.dataset.dinas === dinas;
            var matchJenis  = !jenis  || c.dataset.jenis === jenis;
            return matchSearch && matchDinas && matchJenis;
        });
        currentPage = 1;
        render();
    }

    function render() {
        var total = filtered.length;
        var totalPages = Math.max(1, Math.ceil(total / perPage));
        currentPage = Math.min(currentPage, totalPages);
        var start = (currentPage - 1) * perPage;
        var end   = start + perPage;

        cards.forEach(function(c) { c.style.display = 'none'; });
        var pageItems = filtered.slice(start, end);
        pageItems.forEach(function(c) { c.style.display = ''; });

        document.getElementById('no-results').style.display = (total === 0) ? '' : 'none';
        document.getElementById('pagination-wrap').style.display = (total === 0) ? 'none' : '';

        document.getElementById('results-info').textContent =
            'Menampilkan ' + (total === 0 ? 0 : start + 1) + ' - ' + Math.min(end, total) + ' dari ' + total + ' gedung';
        document.getElementById('page-info').textContent =
            'Halaman ' + currentPage + ' dari ' + totalPages;

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        var wrap = document.getElementById('pagination-btns');
        wrap.innerHTML = '';

        function btn(label, page, active, disabled) {
            var b = document.createElement('button');
            b.className = 'btn btn-sm ' + (active ? 'btn-primary' : 'btn-outline-secondary');
            b.style.minWidth = '34px';
            b.innerHTML = label;
            b.disabled = disabled;
            if (!disabled && !active) b.onclick = function() { currentPage = page; render(); };
            return b;
        }

        wrap.appendChild(btn('<i class="fas fa-chevron-left"></i>', currentPage - 1, false, currentPage === 1));

        var pages = [];
        if (totalPages <= 7) {
            for (var i = 1; i <= totalPages; i++) pages.push(i);
        } else {
            pages = [1, 2];
            if (currentPage > 4) pages.push('...');
            for (var i = Math.max(3, currentPage - 1); i <= Math.min(totalPages - 2, currentPage + 1); i++) pages.push(i);
            if (currentPage < totalPages - 3) pages.push('...');
            pages.push(totalPages - 1, totalPages);
        }

        pages.forEach(function(p) {
            if (p === '...') {
                var s = document.createElement('span');
                s.className = 'btn btn-sm btn-outline-secondary disabled';
                s.textContent = '…';
                wrap.appendChild(s);
            } else {
                wrap.appendChild(btn(p, p, p === currentPage, false));
            }
        });

        wrap.appendChild(btn('<i class="fas fa-chevron-right"></i>', currentPage + 1, false, currentPage === totalPages));
    }

    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('filterDinas').addEventListener('change', applyFilters);
    document.getElementById('filterJenis').addEventListener('change', applyFilters);
    document.getElementById('perPageSelect').addEventListener('change', function() {
        perPage = parseInt(this.value);
        currentPage = 1;
        render();
    });

    render();
})();

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Gedung?',
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

