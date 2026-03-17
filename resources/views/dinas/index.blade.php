<!-- resources/views/dinas/index.blade.php -->

@extends('layouts.main')

@section('page-title', 'Dinas')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Dinas',
    'subtitle' => 'Kelola data OPD / Dinas',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDinasModal"><i class="fas fa-plus me-1"></i>Tambah</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-building me-2 text-primary"></i>Data Dinas</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dinas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dinas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_dinas }}</td>
                            <td class="actions-cell text-center">
                                <form id="formDelete{{ $item->id }}" action="{{ route('dinas.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editDinasModal-{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $item->id }}')">
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
<x-app-modal id="newDinasModal" title="Tambah Dinas" icon="fas fa-plus">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('dinas.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium" for="nama_dinas">Nama Dinas</label>
            <input type="text" class="form-control" id="nama_dinas" name="nama_dinas" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<!-- Modal Edit -->
@foreach ($dinas as $item)
<x-app-modal id="editDinasModal-{{ $item->id }}" title="Edit Dinas" icon="fas fa-edit">
    <form method="POST" action="{{ route('dinas.update', $item->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Dinas</label>
            <input type="text" class="form-control" name="nama_dinas" value="{{ $item->nama_dinas }}" required>
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
        title: 'Hapus Dinas?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        borderRadius: '16px',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formDelete' + id).submit();
        }
    });
}
</script>
@endsection
