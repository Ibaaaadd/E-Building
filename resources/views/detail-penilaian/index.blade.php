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

@include('layouts.page-header', [
    'title'    => 'Detail Penilaian',
    'subtitle' => 'Rincian penilaian indikator bangunan',
    'actions'  => Auth::user()->role_id == 2 && $dtl->detail_penilaian->count() < $jumlahindikator
        ? '<a href="' . route('penilaian.index', $dtl->id) . '" class="btn btn-primary"><i class="fas fa-plus me-1"></i>Nilai</a>'
        : '',
])

<div class="card" data-aos="fade-up">
    <div class="card-header">
        <h5><i class="fas fa-star-half-alt me-2 text-primary"></i>Data Penilaian Indikator</h5>
    </div>
    <div class="card-body card-table-body">
        <div class="table-responsive">
            <table id="tabel" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th>Surveyor</th>
                        <th>Indikator</th>
                        <th class="text-center">Nilai Indikator</th>
                        <th class="text-center">Foto Sebelum</th>
                        <th class="text-center">Nilai Survey</th>
                        <th class="text-center">Foto Survey</th>
                        <th class="text-center">Nilai Sesudah</th>
                        <th class="text-center">Foto Sesudah</th>
                        @if (Auth::user()->role_id == 2 && !($dtl->status == 4))
                            <th class="text-center">Aksi</th>
                        @endif
                        @if (Auth::user()->role_id == 3)
                            <th class="text-center">Survey</th>
                            <th class="text-center">Sesudah</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPenilaians as $detail)
                        <tr class="align-middle">
                            <td>{{ $detail->id_surveyor ? $detail->user->name : '—' }}</td>
                            <td>{{ $detail->indikator->nama_indikator }}</td>
                            <td class="text-center">
                                @for ($i = 0; $i < $detail->nilai_indikator; $i++)
                                    <i class="fas fa-star text-warning" style="font-size:13px;"></i>
                                @endfor
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#gambarSebelum{{ $detail->id }}">
                                    <img class="table-thumb" src="{{ asset('fotoDetail/' . $detail->gambar_sebelum) }}" alt="">
                                </button>
                            </td>
                            <td class="text-center">
                                @for ($i = 0; $i < $detail->nilai_survey; $i++)
                                    <i class="fas fa-star text-warning" style="font-size:13px;"></i>
                                @endfor
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#gambarSurvey{{ $detail->id }}">
                                    <img class="table-thumb" src="{{ asset('fotoDetail/' . $detail->gambar_survey) }}" alt="">
                                </button>
                            </td>
                            <td class="text-center">
                                @for ($i = 0; $i < $detail->nilai_sesudah; $i++)
                                    <i class="fas fa-star text-warning" style="font-size:13px;"></i>
                                @endfor
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#gambarSesudah{{ $detail->id }}">
                                    <img class="table-thumb" src="{{ asset('fotoDetail/' . $detail->gambar_sesudah) }}" alt="">
                                </button>
                            </td>
                            @if (Auth::user()->role_id == 2 && !($dtl->status == 4))
                                <td class="text-center">
                                    <button type="button" class="btn-icon btn-icon-edit" data-bs-toggle="modal" data-bs-target="#detailSebelum{{ $detail->id }}" title="Edit Gambar Sebelum">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            @endif
                            @if (Auth::user()->role_id == 3)
                                <td class="text-center">
                                    <button type="button" class="btn-icon btn-icon-info" data-bs-toggle="modal" data-bs-target="#detailSurvey{{ $detail->id }}" title="Edit Survey">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-icon" style="background:#dcfce7;color:#16a34a;" data-bs-toggle="modal" data-bs-target="#detailSesudah{{ $detail->id }}" title="Edit Sesudah">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Foto Modals --}}
@foreach ($detailPenilaians as $detail)
    <x-photo-modal id="gambarSebelum{{ $detail->id }}" title="Foto Sebelum — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_sebelum) }}" />
    <x-photo-modal id="gambarSurvey{{ $detail->id }}" title="Foto Survey — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_survey) }}" />
    <x-photo-modal id="gambarSesudah{{ $detail->id }}" title="Foto Sesudah — {{ $detail->indikator->nama_indikator }}" src="{{ asset('fotoDetail/' . $detail->gambar_sesudah) }}" />
@endforeach

{{-- Edit Modals --}}
@foreach ($detailPenilaians as $detail)

    {{-- Edit Survey (role 3) --}}
    <x-app-modal id="detailSurvey{{ $detail->id }}" title="Edit Nilai Survey" icon="fas fa-edit">
        <form action="{{ route('detailPenilaian.update', $detail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Gambar Survey</label>
                <input type="file" name="gambar_survey" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Nilai Survey</label>
                <select name="nilai_survey" class="form-select">
                    <option value="" disabled selected>— Pilih Nilai —</option>
                    <option value="1">★ Tidak Layak</option>
                    <option value="2">★★ Rusak Berat</option>
                    <option value="3">★★★ Rusak Sedang</option>
                    <option value="4">★★★★ Rusak Ringan</option>
                    <option value="5">★★★★★ Layak</option>
                </select>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-app-modal>

    {{-- Edit Sesudah (role 3) --}}
    <x-app-modal id="detailSesudah{{ $detail->id }}" title="Edit Gambar Sesudah" icon="fas fa-image">
        <form action="{{ route('detailPenilaian.upload', $detail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Gambar Sesudah</label>
                <input type="file" name="gambar_sesudah" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Nilai Sesudah</label>
                <select name="nilai_sesudah" class="form-select">
                    <option value="" disabled selected>— Pilih Nilai —</option>
                    <option value="1">★ Tidak Layak</option>
                    <option value="2">★★ Rusak Berat</option>
                    <option value="3">★★★ Rusak Sedang</option>
                    <option value="4">★★★★ Rusak Ringan</option>
                    <option value="5">★★★★★ Layak</option>
                </select>
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-app-modal>

    {{-- Edit Sebelum (role 2) --}}
    <x-app-modal id="detailSebelum{{ $detail->id }}" title="Edit Gambar Sebelum" icon="fas fa-image">
        <form action="{{ route('detailPenilaian.ganti', $detail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Gambar Sebelum</label>
                <input type="file" name="gambar_sebelum" class="form-control" accept="image/*">
            </div>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-app-modal>

@endforeach

@endsection
