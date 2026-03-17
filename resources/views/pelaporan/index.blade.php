@extends('layouts.main')
@section('page-title', 'Laporan')
@section('contents')

{{-- Toast on success --}}
@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title' => 'Laporan',
    'subtitle' => 'Data laporan masuk dari pelapor',
    'actions' => Auth::user()->role_id == 2
        ? '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPelaporanModal"><i class="fas fa-plus me-1"></i>Buat Laporan</button>'
        : '<button class="btn btn-success" onclick="exportToExcel()"><i class="fas fa-file-excel me-1"></i>Export Excel</button>',
])

{{-- DataTable card --}}
<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-file-alt me-2 text-primary"></i>Data Laporan</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Dinas</th>
                        <th>Gedung</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th class="text-center">E-Surat</th>
                        <th class="actions-cell text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelaporans as $pelaporan)
                    <tr>
                        <td>{{ $pelaporan->dinas->nama_dinas }}</td>
                        <td>{{ $pelaporan->gedung->nama_gedung }}</td>
                        <td>{{ \Carbon\Carbon::parse($pelaporan->tanggal_laporan)->translatedFormat('d M Y') }}</td>
                        <td style="max-width:220px;white-space:normal;">{{ $pelaporan->deskripsi_laporan }}</td>
                        <td class="text-center">
                            @if ($pelaporan->surat)
                                <button type="button" class="btn-icon btn-icon-pdf" data-bs-toggle="modal" data-bs-target="#modalSurat{{ $pelaporan->id }}" title="Lihat Surat">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            @else
                                <span class="badge bg-secondary">Tidak ada</span>
                            @endif
                        </td>
                        <td class="actions-cell text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('detail.index', $pelaporan->id) }}" class="btn-icon btn-icon-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (Auth::user()->role_id == 2 && $pelaporan->status == 0)
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editPelaporanModal{{ $pelaporan->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form id="formDelete{{ $pelaporan->id }}" action="{{ route('pelaporan.destroy', $pelaporan->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $pelaporan->id }}')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PDF Surat Modals --}}
@foreach ($pelaporans as $pelaporan)
    @if($pelaporan->surat)
        <x-pdf-modal id="modalSurat{{ $pelaporan->id }}" title="Surat — {{ $pelaporan->gedung->nama_gedung }}" src="{{ asset('fotoSurat/' . $pelaporan->surat) }}" />
    @endif
@endforeach

{{-- Edit Modals --}}
@foreach ($pelaporans as $pelaporan)
<x-app-modal id="editPelaporanModal{{ $pelaporan->id }}" title="Edit Laporan" icon="fas fa-edit" size="lg">
    <form method="POST" action="{{ route('pelaporan.update', $pelaporan->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Deskripsi Laporan</label>
            <textarea class="form-control" name="deskripsi_laporan" rows="4" required>{{ $pelaporan->deskripsi_laporan }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Surat (opsional, ganti jika ingin update)</label>
            <input type="file" class="form-control" name="surat" accept=".pdf">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endforeach

{{-- Create Modal (role 2 only) --}}
@if (Auth::user()->role_id == 2)
<x-app-modal id="createPelaporanModal" title="Buat Laporan" icon="fas fa-file-alt" size="lg">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('pelaporan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Dinas</label>
            <select class="form-select pilihdinas" id="id_dinas" name="id_dinas" required>
                @foreach ($dinas as $d)
                    <option value="{{ $d->id }}" data-nama="{{ $d->nama_dinas }}">{{ $d->nama_dinas }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Gedung</label>
            <select class="form-select" id="id_gedung" name="id_gedung" required>
                @foreach ($gedungs as $gedung)
                    <option value="{{ $gedung->id }}" data-dinas="{{ $gedung->id_dinas }}">{{ $gedung->nama_gedung }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal Laporan</label>
            <input type="date" class="form-control" id="tanggal_laporan" name="tanggal_laporan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi Laporan</label>
            <textarea class="form-control" name="deskripsi_laporan" rows="3" required></textarea>
            @error('deskripsi_laporan')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Surat (PDF)</label>
            <input type="file" class="form-control" name="surat" accept=".pdf" required>
            @error('surat')<div class="text-danger" style="font-size:12px;">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endif

<script>
// Filter gedung options based on selected dinas
document.addEventListener('DOMContentLoaded', function () {
    const dinasSelect = document.getElementById('id_dinas');
    const gedungSelect = document.getElementById('id_gedung');

    if (dinasSelect && gedungSelect) {
        const allGedungOptions = Array.from(gedungSelect.options);

        function filterGedung() {
            const selectedDinas = dinasSelect.value;
            gedungSelect.innerHTML = '';
            allGedungOptions.forEach(function (option) {
                if (option.dataset.dinas === selectedDinas) {
                    gedungSelect.appendChild(option.cloneNode(true));
                }
            });
        }

        dinasSelect.addEventListener('change', filterGedung);
        filterGedung();
    }
});

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Laporan?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDelete' + id).submit();
        }
    });
}
</script>
@endsection
