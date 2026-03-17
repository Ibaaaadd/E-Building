<!-- resources/views/penilaian/index.blade.php -->

@extends('layouts.main')

@section('contents')
    <div class="container mt-3">
        <form action="{{ route('penilaian.simpan', $id_detail) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container mt-3 mb-3">
                <div class="row">
                    @foreach ($aspeks as $key => $value)
                        <div class="col-md-12 mb-2 mt-2">
                            <!-- Isi baris pertama -->
                            <div class="card h-100" style="box-shadow: 5px 5px 5px #888888;">
                                <div class="card-header" style="background-color: #EEF5FF !important; color: #102C57;">
                                    <div class="d-flex justify-content-center">
                                        <h2 class="text-dark fw-bold m-2">Aspek {{ $value->nama_aspek }}</h2>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @foreach ($value->indikator as $v)
                                        @php
                                            $cek = \App\Models\DetailPenilaian::where('id_indikator', $v->id)
                                                ->where('id_detail', $id_detail)
                                                ->first();
                                        @endphp
                                        @if (!$cek)
                                            <div class="row">
                                                <h5 class="text-dark fw-bold m-2">{{ $v->nama_indikator }}</h5>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <label class="input-group-text"
                                                                for="inputGroupSelect{{ $v->id }}">Nilai</label>
                                                            <select class="form-select" name="nilai[]"
                                                                id="inputGroupSelect{{ $v->id }}" required>
                                                                <option value="" selected disabled
                                                                    class="text-center">-- Pilih Nilai --</option>
                                                                <option value="1">&#9733; Tidak Layak</option>
                                                                <option value="2">&#9733;&#9733; Rusak Berat</option>
                                                                <option value="3">&#9733;&#9733;&#9733; Rusak Sedang
                                                                </option>
                                                                <option value="4">&#9733;&#9733;&#9733;&#9733; Rusak
                                                                    Ringan</option>
                                                                <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;
                                                                    Layak</option>
                                                            </select>
                                                            <input type="hidden" name="indikator_id[]"
                                                                value="{{ $v->id }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <label class="input-group-text"
                                                                for="inputGroupFile{{ $v->id }}">Foto</label>
                                                            <input type="file" name="gambar_sebelum[]"
                                                                class="form-control" id="inputGroupFile{{ $v->id }}"
                                                                required>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="showImageModal('{{ $v->id }}')"><i
                                                                    class="far fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal untuk menampilkan foto -->
                                            <div class="modal fade" id="imageModal-{{ $v->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-centered text-center" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel">
                                                                <h4 class="text-dark fw-bold m-1">Gambar</h4>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="" id="modalImage-{{ $v->id }}"
                                                                class="img-fluid" alt="Gambar">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Button Submit di sini -->
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    @endsection

    <script>
        function showImageModal(indikatorId) {
            var modalId = 'imageModal-' + indikatorId;
            var modal = document.getElementById(modalId);

            // Temukan gambar di dalam modal
            var modalImage = modal.querySelector('.modal-body img');

            // Mendapatkan nilai URL gambar yang dipilih (misalnya dari input file)
            var selectedFile = document.getElementById('inputGroupFile' + indikatorId).files[0];

            // Periksa apakah file gambar telah dipilih
            if (selectedFile) {
                // Buat objek URL untuk file gambar yang dipilih
                var imageUrl = URL.createObjectURL(selectedFile);

                // Setel nilai src pada elemen gambar modal
                modalImage.src = imageUrl;
            }

            // Tampilkan modal
            $(modal).modal('show');
        }
    </script>
