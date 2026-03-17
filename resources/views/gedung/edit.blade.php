<!-- resources/views/gedung/edit.blade.php -->

@extends('layouts.main')

@section('contents')
    <!-- resources/views/gedung/edit.blade.php -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" text-center fw-bold" style="padding-bottom: 15px">
                    <h2 class="text-dark fw-bold m-2">Edit Gedung</h2>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('gedung.update', $gedung->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="id_dinas">Dinas</label>
                                        <select class="form-control" id="id_dinas" name="id_dinas" required>
                                            @foreach ($dinas as $singleDinas)
                                                <option value="{{ $singleDinas->id }}">{{ $singleDinas->nama_dinas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="id_jenis">Jenis</label>
                                        <select class="form-control" id="id_jenis" name="id_jenis" required>
                                            @foreach ($jenis as $j)
                                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="nama_gedung">Nama Gedung</label>
                                        <input type="text" class="form-control" id="nama_gedung" name="nama_gedung"
                                            value="{{ $gedung->nama_gedung }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="foto_gedung">Foto Gedung</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="foto_gedung" name="foto_gedung"
                                                aria-describedby="inputGroupFileAddon02" value="{{ $gedung->foto_gedung }}">
                                            <label class="input-group-text" for="foto_gedung"
                                                id="inputGroupFileAddon02">Upload</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mb-3">
                                <label class="mb-2" for="alamat_gedung">Alamat Gedung</label>
                                <textarea class="form-control " id="alamat_gedung" name="alamat_gedung">{{ $gedung->alamat_gedung }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="luas_gedung">Luas Gedung</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control " id="luas_gedung" name="luas_gedung"
                                                value="{{ $gedung->luas_gedung }}">
                                            <span class="input-group-text" id="luas_gedung-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="luas_tanah">Luas Tanah</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control " id="luas_tanah" name="luas_tanah"
                                                value="{{ $gedung->luas_tanah }}">
                                            <span class="input-group-text" id="luas_tanah-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" class="form-control" id="longitude" name="longitude"
                                    placeholder="Longitude" value="{{ $gedung->longitude }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" class="form-control" id="latitude" name="latitude"
                                    placeholder="Latitude" value="{{ $gedung->latitude }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div id="mapid" style="height: 400px;"></div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('gedung.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('mapid').setView([-7.2575, 112.7521], 13);

        // Tambahkan layer peta tile dari OpenStreetMap
        var layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        map.addLayer(layer);
        var marker = null;
        map.on('click', (event) => {
            // Hapus marker sebelumnya jika ada
            if (marker !== null) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru pada koordinat yang diklik
            marker = L.marker([event.latlng.lat, event.latlng.lng]).addTo(map);

            // Set nilai latitude dan longitude pada input
            document.getElementById('latitude').value = event.latlng.lat;
            document.getElementById('longitude').value = event.latlng.lng;
        });

        var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false, // Tidak menandai hasil geocode secara otomatis
                placeholder: 'Cari Alamat...',
                collapsed: false // Tampilkan kotak pencarian secara default
            })
            .on('markgeocode', function(e) {
                var latlng = e.geocode.center;
                map.setView(latlng, 16); // Zoom ke hasil geocode dengan level 16

                if (marker !== null) {
                    map.removeLayer(marker); // Hapus marker sebelumnya jika ada
                }

                marker = L.marker(latlng).addTo(map); // Tambahkan marker baru
                document.getElementById('latitude').value = latlng.lat;
                document.getElementById('longitude').value = latlng.lng;
            })
            .addTo(map);
    </script>
@endsection
