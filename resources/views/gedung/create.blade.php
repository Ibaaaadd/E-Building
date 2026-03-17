@extends('layouts.main')

@section('contents')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" text-center fw-bold" style="padding-bottom: 15px">
                    <h2 class="text-dark fw-bold m-2">Gedung Baru</h2>
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

                        <form method="POST" action="{{ route('gedung.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Formulir input -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="id_dinas"><b>Dinas</b></label>
                                        <select class="form-control" id="id_dinas" name="id_dinas" required>
                                            <option value="" disabled selected>-- Pilih dinas --</option>
                                            @foreach ($dinas as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama_dinas }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_dinas')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="id_jenis"><b>Jenis</b></label>
                                        <select class="form-control" id="id_jenis" name="id_jenis" required>
                                            <option value="" disabled selected>-- Pilih Jenis --</option>
                                            @foreach ($jenis as $j)
                                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_jenis')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="nama_gedung">Nama Gedung</label>
                                        <input type="text" class="form-control" placeholder="Nama " id="nama_gedung"
                                            name="nama_gedung" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2" for="foto_gedung">Foto</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="foto_gedung" name="foto_gedung"
                                                aria-describedby="inputGroupFileAddon02">
                                            <label class="input-group-text" for="foto_gedung"
                                                id="inputGroupFileAddon02">Upload</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-2" for="alamat_gedung">Alamat Gedung</label>
                                <textarea class="form-control" placeholder="Alamat " id="alamat_gedung" name="alamat_gedung"></textarea>
                            </div>

                            <div class="row">
                                <label class="mb-2">Luas</label>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Gedung" id="luas_gedung"
                                                name="luas_gedung" aria-label="Luas Gedung"
                                                aria-describedby="luas_gedung-addon">
                                            <span class="input-group-text" id="luas_gedung-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Tanah" id="luas_tanah"
                                                name="luas_tanah" aria-label="Luas Tanah"
                                                aria-describedby="luas_tanah-addon">
                                            <span class="input-group-text" id="luas_tanah-addon">m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" class="form-control" id="longitude" name="longitude"
                                    placeholder="Longitude" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="hidden" class="form-control" id="latitude" name="latitude"
                                    placeholder="Latitude" required>
                            </div>

                            <div class="row">
                                <label class="mb-2" for="latitude">Map</b></label>
                                <div class="col-md-12">
                                    <div id="mapid" style="height: 400px;"></div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" href="{{ route('gedung.index') }}" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
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

        var layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

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
            defaultMarkGeocode: false,
            placeholder: 'Cari Alamat...',
            collapsed: false
        }).on('markgeocode', function(e) {
            var latlng = e.geocode.center;
            map.setView(latlng, 16);

            if (marker !== null) {
                map.removeLayer(marker);
            }

            marker = L.marker(latlng).addTo(map);
            document.getElementById('latitude').value = latlng.lat;
            document.getElementById('longitude').value = latlng.lng;
        }).addTo(map);
    </script>
@endsection
