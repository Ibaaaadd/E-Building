@extends('layouts.main')

@section('page-title', 'Aspek')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Aspek',
    'subtitle' => 'Kelola data aspek penilaian',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAspekModal"><i class="fas fa-plus me-1"></i>Tambah</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-tasks me-2 text-primary"></i>Data Aspek</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aspek</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspeks as $i => $aspek)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $aspek->nama_aspek }}</td>
                            <td class="actions-cell text-center">
                                <form id="formDelete{{ $aspek->id }}" action="{{ route('aspek.destroy', $aspek->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editAspekModal-{{ $aspek->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $aspek->id }}')">
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
<x-app-modal id="newAspekModal" title="Tambah Aspek" icon="fas fa-plus">
    <form method="POST" action="{{ route('aspek.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Aspek</label>
            <input type="text" class="form-control" name="nama_aspek" required>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<!-- Modal Edit -->
@foreach ($aspeks as $aspek)
<x-app-modal id="editAspekModal-{{ $aspek->id }}" title="Edit Aspek" icon="fas fa-edit">
    <form method="POST" action="{{ route('aspek.update', $aspek->id) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Nama Aspek</label>
            <input type="text" class="form-control" name="nama_aspek" value="{{ $aspek->nama_aspek }}" required>
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
        title: 'Hapus Aspek?',
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
