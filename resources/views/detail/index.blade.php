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
    'actions'  => Auth::user()->role_id == 2
        ? '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDetailModal"><i class="fas fa-plus me-1"></i>Tambah Bidang</button>'
        : '',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-clipboard-list me-2 text-primary"></i>Data Bidang</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Bidang</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                        @if (Auth::user()->role_id != 2)
                            <th class="text-center">Progres</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $d)
                        <tr>
                            <td class="align-middle">{{ $d->user->name }}</td>
                            <td class="align-middle">{{ $d->bidang }}</td>
                            <td class="text-center align-middle">
                                @if ($d->status == 0)
                                    <span class="badge text-bg-secondary">Menunggu Survey</span>
                                @elseif ($d->status == 1)
                                    <span class="badge text-bg-warning">Survey</span>
                                @elseif ($d->status == 2)
                                    <span class="badge text-bg-info">Pengerjaan</span>
                                @elseif ($d->status == 3)
                                    <span class="badge text-bg-success">Selesai</span>
                                @elseif ($d->status == -1)
                                    <span class="badge text-bg-danger">Ditolak</span>
                                @endif
                                <div class="mt-1" style="font-size:11px;color:#94a3b8;">{{ $d->updated_at->format('d M') }}</div>
                            </td>
                            <td class="text-center align-middle">
                                <form id="formDelete{{ $d->id }}" action="{{ route('detail.destroy', $d->id) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button" class="btn-icon btn-icon-info" data-bs-toggle="modal" data-bs-target="#logModal{{ $d->id }}" title="Riwayat Status">
                                        <i class="fas fa-history"></i>
                                    </button>
                                    <a href="{{ route('penilaian.detail', $d->id) }}" class="btn-icon" style="background:#e0f2fe;color:#0284c7;" title="Detail Penilaian">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                    @if (Auth::user()->role_id == 2 && $d->status != 1)
                                        <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#editDetailModal-{{ $d->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn-icon btn-icon-delete" onclick="confirmDelete('{{ $d->id }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            @if (Auth::user()->role_id != 2)
                                <td class="text-center align-middle">
                                    <form action="{{ route('detail.updateStatus', $d->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        @if (Auth::user()->role_id == 3 && $d->status == 0)
                                            <button type="submit" name="status" value="1" class="btn btn-sm btn-primary">
                                                <i class="fas fa-clipboard-check"></i>
                                            </button>
                                        @endif
                                        @if (Auth::user()->role_id == 4 && $d->status == 1)
                                            <button type="submit" name="status" value="2" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="submit" name="status" value="-1" class="btn btn-sm btn-danger ms-1">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        @if (Auth::user()->role_id == 3 && $d->status == 2)
                                            <button type="submit" name="status" value="3" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-flag-checkered"></i>
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
            <label class="form-label" for="bidangEdit{{ $d->id }}">Nama Bidang</label>
            <input type="text" class="form-control" id="bidangEdit{{ $d->id }}" name="bidang" value="{{ $d->bidang }}" required>
        </div>
        <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</x-app-modal>
@endforeach

{{-- Log / Riwayat Status Modals --}}
@foreach ($details as $d)
<div class="modal fade" id="logModal{{ $d->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold"><i class="fas fa-history me-2 text-primary"></i>Riwayat Status — {{ $d->bidang }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($d->status >= 0 && $d->user)
                            <tr>
                                <td class="ps-4">{{ $d->user->name }}</td>
                                <td class="text-center"><span class="badge text-bg-secondary">Menunggu Survey</span></td>
                                <td class="text-center pe-4">{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            </tr>
                        @endif
                        @if ($d->status >= 1 && $d->surveyUser)
                            <tr>
                                <td class="ps-4">{{ $d->surveyUser->name }}</td>
                                <td class="text-center"><span class="badge text-bg-warning">Survey</span></td>
                                <td class="text-center pe-4">{{ \Carbon\Carbon::parse($d->survey_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            </tr>
                        @endif
                        @if ($d->status >= 2 && $d->accUser)
                            <tr>
                                <td class="ps-4">{{ $d->accUser->name }}</td>
                                <td class="text-center"><span class="badge text-bg-info">Pengerjaan</span></td>
                                <td class="text-center pe-4">{{ \Carbon\Carbon::parse($d->acc_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            </tr>
                        @endif
                        @if ($d->status >= 3 && $d->selesaiUser)
                            <tr>
                                <td class="ps-4">{{ $d->selesaiUser->name }}</td>
                                <td class="text-center"><span class="badge text-bg-success">Selesai</span></td>
                                <td class="text-center pe-4">{{ \Carbon\Carbon::parse($d->selesai_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            </tr>
                        @endif
                        @if ($d->status == -1 && $d->tolakUser)
                            <tr>
                                <td class="ps-4">{{ $d->tolakUser->name }}</td>
                                <td class="text-center"><span class="badge text-bg-danger">Ditolak</span></td>
                                <td class="text-center pe-4">{{ \Carbon\Carbon::parse($d->tolak_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
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
        if (result.isConfirmed) {
            document.getElementById('formDelete' + id).submit();
        }
    });
}
</script>

@endsection
