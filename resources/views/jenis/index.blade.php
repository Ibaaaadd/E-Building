@extends('layouts.main')

@section('page-title', 'Jenis')

@section('contents')

@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ $message }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
});
</script>
@endif

@include('layouts.page-header', [
    'title'    => 'Jenis',
    'subtitle' => 'Kelola data jenis gedung',
    'actions'  => '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJenisModal"><i class="fas fa-plus me-1"></i>Tambah</button>',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-tags me-2 text-primary"></i>Data Jenis</h5>
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
                    @foreach ($jenis as $index => $jeni)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jeni->nama }}</td>
                            <td>{{ $jeni->detail }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#gambarSebelum{{ $jeni->id }}">
                                    <img class="table-thumb"
                                        src="{{ asset('fotoJenis/' . $jeni->foto) }}" alt="{{ $jeni->nama }}">
                                </button>
                            </td>
                            <td class="actions-cell text-center">
                                <form id="delete-form-{{ $jeni->id }}" action="{{ route('jenis.destroy', $jeni->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editJenisModal{{ $jeni->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete({{ $jeni->id }})">
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
@foreach ($jenis as $jeni)
<x-photo-modal id="gambarSebelum{{ $jeni->id }}" title="{{ $jeni->nama }}" src="{{ asset('fotoJenis/' . $jeni->foto) }}" />
@endforeach

<!-- Edit Modals -->
@foreach ($jenis as $jeni)
<x-app-modal id="editJenisModal{{ $jeni->id }}" title="Edit Jenis" icon="fas fa-edit">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form action="{{ route('jenis.update', $jeni->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label fw-medium">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ $jeni->nama }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Detail</label>
            <textarea class="form-control" name="detail" required>{{ $jeni->detail }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Sektor</label>
            <select class="form-select" name="id_sektor" required>
                @foreach ($sektors as $sektor)
                    <option value="{{ $sektor->id }}" {{ $jeni->id_sektor == $sektor->id ? 'selected' : '' }}>{{ $sektor->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Foto</label>
            <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.gif" onchange="previewImage(this, 'previewEditJenis{{ $jeni->id }}')">
            <div class="mt-2 text-center">
                <img id="previewEditJenis{{ $jeni->id }}" src="{{ asset('fotoJenis/' . $jeni->foto) }}" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: contain;">
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>
@endforeach

<!-- Create Modal -->
<x-app-modal id="createJenisModal" title="Tambah Jenis" icon="fas fa-plus">
    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('jenis.store') }}" enctype="multipart/form-data">
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
            <label class="form-label fw-medium">Sektor</label>
            <select class="form-select" name="id_sektor" required>
                @foreach ($sektors as $sektor)
                    <option value="{{ $sektor->id }}">{{ $sektor->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-medium">Foto (Wajib)</label>
            <input type="file" class="form-control" name="foto" accept=".jpg,.jpeg,.png,.gif" required onchange="previewImage(this, 'previewCreateJenis')">
            <div class="mt-2 text-center">
                <img id="previewCreateJenis" src="" alt="Preview" style="max-width: 100%; max-height: 200px; display: none; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: contain;">
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </form>
</x-app-modal>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}

function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Jenis?',
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

