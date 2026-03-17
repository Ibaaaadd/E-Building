<!-- resources/views/indikator/index.blade.php -->

@extends('layouts.main')

@section('page-title', 'Indikator')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Indikator',
    'subtitle' => 'Kelola data indikator penilaian',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIndikatorModal"><i class="fas fa-plus me-1"></i>Tambah</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-list-check me-2 text-primary"></i>Data Indikator</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aspek</th>
                        <th>Indikator</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indikators as $indikator)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $indikator->aspek->nama_aspek }}</td>
                            <td>{{ $indikator->nama_indikator }}</td>
                            <td class="actions-cell text-center">
                                <form id="formDelete{{ $indikator->id }}" action="{{ route('indikator.destroy', $indikator->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editIndikatorModal-{{ $indikator->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $indikator->id }}')">
                                        <i class="fas fa-trash-alt"></i>
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

<!-- Modal Create -->
<x-app-modal id="newIndikatorModal" title="Tambah Indikator" icon="fas fa-plus">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('indikator.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium">Aspek</label>
            <select class="form-select" name="id_aspek">
                @foreach ($aspeks as $aspek)
                    <option value="{{ $aspek->id }}">{{ $aspek->nama_aspek }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Indikator</label>
            <input type="text" class="form-control" name="nama_indikator" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<!-- Modal Edit -->
@foreach ($indikators as $indikator)
<x-app-modal id="editIndikatorModal-{{ $indikator->id }}" title="Edit Indikator" icon="fas fa-edit">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('indikator.update', $indikator->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Aspek</label>
            <select class="form-select" name="id_aspek" required>
                @foreach ($aspeks as $aspek)
                    <option value="{{ $aspek->id }}" {{ $aspek->id == $indikator->id_aspek ? 'selected' : '' }}>
                        {{ $aspek->nama_aspek }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Indikator</label>
            <input type="text" class="form-control" name="nama_indikator" value="{{ $indikator->nama_indikator }}" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endforeach

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Indikator?',
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
