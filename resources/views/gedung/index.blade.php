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

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-city me-2 text-primary"></i>Data Gedung</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Nama Dinas</th>
                        <th>Nama Gedung</th>
                        <th>Jenis</th>
                        <th>Alamat</th>
                        <th>Luas Gedung</th>
                        <th>Luas Tanah</th>
                        <th class="text-center">Foto</th>
                        <th class="text-center">Koordinat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gedungs as $gedung)
                        <tr>
                            <td>{{ $gedung->dinas->nama_dinas }}</td>
                            <td>{{ $gedung->nama_gedung }}</td>
                            <td>{{ $gedung->jenis->nama }}</td>
                            <td>{{ $gedung->alamat_gedung }}</td>
                            <td>{{ $gedung->luas_gedung }} m²</td>
                            <td>{{ $gedung->luas_tanah }} m²</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $gedung->id }}">
                                    <img class="table-thumb"
                                        src="{{ asset('fotoGedung/' . $gedung->foto_gedung) }}" alt="">
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn-icon btn-icon-map" data-bs-toggle="modal" data-bs-target="#koordinatGedungModal-{{ $gedung->id }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                            </td>
                            <td class="actions-cell text-center">
                                <form id="formDelete{{ $gedung->id }}" action="{{ route('gedung.destroy', $gedung->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('gedung.edit', $gedung->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $gedung->id }}')" title="Hapus">
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

<!-- Foto Modals -->
@foreach ($gedungs as $gedung)
<x-photo-modal id="modalFoto{{ $gedung->id }}" title="Foto Gedung" src="{{ asset('fotoGedung/' . $gedung->foto_gedung) }}" />
@endforeach

<!-- Koordinat Modals -->
@foreach ($gedungs as $gedung)
<div class="modal fade" id="koordinatGedungModal-{{ $gedung->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Koordinat — {{ $gedung->nama_gedung }}</h5>
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
        if (result.isConfirmed) {
            document.getElementById('formDelete' + id).submit();
        }
    });
}
</script>
@endsection
