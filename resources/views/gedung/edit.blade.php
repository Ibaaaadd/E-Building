@extends('layouts.main')

@section('page-title', 'Edit Gedung')

@section('contents')

@include('layouts.page-header', [
    'title'    => 'Edit Gedung',
    'subtitle' => 'Perbarui data gedung',
    'actions'  => '<a href="' . route('gedung.index') . '" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>',
])

<form method="POST" action="{{ route('gedung.update', $gedung->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if ($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="row g-4">

        <div class="col-12">
            <div class="card" data-aos="fade-up">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Gedung</h5>
                </div>
                <div class="card-body" style="padding:24px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="id_dinas">Dinas <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_dinas" name="id_dinas" required>
                                <option value="" disabled>— Pilih Dinas —</option>
                                @foreach ($dinas as $d)
                                    <option value="{{ $d->id }}" {{ $gedung->id_dinas == $d->id ? 'selected' : '' }}>{{ $d->nama_dinas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="id_jenis">Jenis <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_jenis" name="id_jenis" required>
                                <option value="" disabled>— Pilih Jenis —</option>
                                @foreach ($jenis as $j)
                                    <option value="{{ $j->id }}" {{ $gedung->id_jenis == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="nama_gedung">Nama Gedung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_gedung" name="nama_gedung"
                                value="{{ old('nama_gedung', $gedung->nama_gedung) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="alamat_gedung">Alamat</label>
                            <input type="text" class="form-control" id="alamat_gedung" name="alamat_gedung"
                                value="{{ old('alamat_gedung', $gedung->alamat_gedung) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Luas Gedung</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="luas_gedung"
                                    value="{{ old('luas_gedung', $gedung->luas_gedung) }}">
                                <span class="input-group-text">m²</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Luas Tanah</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="luas_tanah"
                                    value="{{ old('luas_tanah', $gedung->luas_tanah) }}">
                                <span class="input-group-text">m²</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="foto_gedung">Foto Gedung</label>
                            @if ($gedung->foto_gedung)
                            <div id="foto-current" class="mb-2 d-flex align-items-center gap-3">
                                <img src="{{ asset('fotoGedung/' . $gedung->foto_gedung) }}" alt="Foto" class="rounded"
                                    style="height:72px;width:72px;object-fit:cover;border:2px solid #e2e8f0;">
                                <small class="text-muted">Foto saat ini — upload baru untuk mengganti</small>
                            </div>
                            @endif
                            <input type="file" class="form-control" id="foto_gedung" name="foto_gedung" accept="image/*"
                                onchange="previewFoto(this)">
                            <div id="foto-preview-wrap" class="mt-2 d-flex align-items-center gap-2" style="display:none!important;">
                                <img id="foto-preview" src="" alt="Preview" class="rounded"
                                    style="height:72px;width:72px;object-fit:cover;border:2px solid var(--accent,#f97316);">
                                <div>
                                    <div id="foto-preview-name" class="fw-semibold" style="font-size:13px;"></div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="clearFoto()">
                                        <i class="fas fa-times me-1"></i>Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map card full width --}}
        <div class="col-12">
            <div class="card" data-aos="fade-up" data-aos-delay="50" style="overflow:visible;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i>Koordinat Lokasi</h5>
                    <div id="coord-display" style="font-size:13px;color:#64748b;display:flex;gap:10px;align-items:center;">
                        <i class="fas fa-map-marker-alt" style="color:#ef4444;"></i>
                        <span>
                            @if($gedung->latitude && $gedung->longitude)
                                <b>Lat:</b> {{ $gedung->latitude }} &nbsp; <b>Lng:</b> {{ $gedung->longitude }}
                            @else
                                Klik peta untuk menentukan koordinat
                            @endif
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding:0;overflow:visible;">
                    <input type="hidden" id="latitude"  name="latitude"  value="{{ $gedung->latitude }}" required>
                    <input type="hidden" id="longitude" name="longitude" value="{{ $gedung->longitude }}" required>
                    <div id="mapid" style="height:420px;border-radius:0 0 16px 16px;"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Actions --}}
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i>Update</button>
        <a href="{{ route('gedung.index') }}" class="btn btn-secondary px-4">Batal</a>
    </div>

</form>

<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var initLat = parseFloat('{{ $gedung->latitude ?? -7.2575 }}') || -7.2575;
    var initLng = parseFloat('{{ $gedung->longitude ?? 112.7521 }}') || 112.7521;
    var hasCoord = {{ ($gedung->latitude && $gedung->longitude) ? 'true' : 'false' }};

    var map = L.map('mapid').setView([initLat, initLng], hasCoord ? 16 : 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = null;

    function setMarker(latlng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([latlng.lat, latlng.lng]).addTo(map);
        document.getElementById('latitude').value  = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
        document.getElementById('coord-display').innerHTML =
            '<i class="fas fa-map-marker-alt" style="color:#ef4444;"></i>' +
            '<span><b>Lat:</b> ' + latlng.lat.toFixed(6) + ' &nbsp; <b>Lng:</b> ' + latlng.lng.toFixed(6) + '</span>';
    }

    // Place existing marker
    if (hasCoord) {
        marker = L.marker([initLat, initLng]).addTo(map);
    }

    map.on('click', function(e) { setMarker(e.latlng); });

    L.Control.geocoder({
        defaultMarkGeocode: false,
        placeholder: 'Cari alamat...',
        collapsed: false
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        map.setView(latlng, 16);
        setMarker(latlng);
    }).addTo(map);

    setTimeout(function() { map.invalidateSize(); }, 200);
});
</script>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('foto-preview').src = e.target.result;
            var wrap = document.getElementById('foto-preview-wrap');
            wrap.style.cssText = 'display:flex!important;align-items:center;gap:8px;margin-top:8px;';
            document.getElementById('foto-preview-name').textContent = input.files[0].name;
            var cur = document.getElementById('foto-current');
            if (cur) cur.style.opacity = '0.4';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearFoto() {
    document.getElementById('foto_gedung').value = '';
    document.getElementById('foto-preview').src = '';
    document.getElementById('foto-preview-wrap').style.cssText = 'display:none!important;';
    var cur = document.getElementById('foto-current');
    if (cur) cur.style.opacity = '1';
}
</script>

@endsection
