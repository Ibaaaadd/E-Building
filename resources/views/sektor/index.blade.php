@extends('layouts.main')

@section('page-title', 'Sektor')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Sektor',
    'subtitle' => 'Kelola data sektor',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSektorModal"><i class="fas fa-plus me-1"></i>Tambah</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-layer-group me-2 text-primary"></i>Data Sektor</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Detail</th>
                        <th class="text-center">Foto</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sektor as $index => $sek)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sek->nama }}</td>
                            <td>{{ $sek->detail }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#gambarSebelum{{ $sek->id }}">
                                    <img class="table-thumb"
                                        src="{{ asset('fotoSektor/' . $sek->foto) }}" alt="{{ $sek->nama }}">
                                </button>
                            </td>
                            <td class="actions-cell text-center">
                                <form id="delete-form-{{ $sek->id }}" action="{{ route('sektor.destroy', $sek->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editSektorModal{{ $sek->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete({{ $sek->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                </div>
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Foto Modals -->
@foreach ($sektor as $sek)
<x-photo-modal id="gambarSebelum{{ $sek->id }}" title="{{ $sek->nama }}" src="{{ asset('fotoSektor/' . $sek->foto) }}" />
@endforeach

<!-- Edit Modals -->
@foreach ($sektor as $sek)
<x-app-modal id="editSektorModal{{ $sek->id }}" title="Edit Sektor" icon="fas fa-edit">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('sektor.update', $sek->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ $sek->nama }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Detail</label>
            <textarea class="form-control" name="detail" required>{{ $sek->detail }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Foto</label>
            <input type="file" class="form-control" name="foto">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endforeach

<!-- Create Modal -->
<x-app-modal id="createSektorModal" title="Tambah Sektor" icon="fas fa-plus">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('sektor.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Detail</label>
            <textarea class="form-control" name="detail" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Foto</label>
            <input type="file" class="form-control" name="foto">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Sektor?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
