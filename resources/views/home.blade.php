@extends('layouts.main')

@section('page-title', 'Dashboard')

@section('contents')

<style>
    .stat-card-item {
        background: white;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #f1f5f9;
        height: 100%;
    }
    .stat-card-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.10);
    }
    .stat-card-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 20px;
    }
    .stat-card-value {
        font-size: 30px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1;
    }
    .stat-card-title {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        margin-top: 4px;
    }
</style>

{{-- Page Header --}}
@include('layouts.page-header', ['title' => 'Dashboard', 'subtitle' => 'Ringkasan data sistem e-Building'])

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @include('layouts.stat-card', [
        'title'  => 'Jumlah Gedung',
        'value'  => $gedung,
        'icon'   => 'fas fa-city',
        'color'  => 'blue',
        'href'   => route('gedung.index'),
        'delay'  => 0,
    ])
    @include('layouts.stat-card', [
        'title'  => 'Jumlah OPD',
        'value'  => $dinas,
        'icon'   => 'fas fa-building',
        'color'  => 'green',
        'href'   => route('dinas.index'),
        'delay'  => 1,
    ])
    @include('layouts.stat-card', [
        'title'  => 'Jumlah Laporan',
        'value'  => $pelaporan,
        'icon'   => 'fas fa-file-alt',
        'color'  => 'purple',
        'href'   => route('pelaporan.index'),
        'delay'  => 2,
    ])
    @include('layouts.stat-card', [
        'title'  => 'Jumlah Sektor',
        'value'  => $sektor,
        'icon'   => 'fas fa-layer-group',
        'color'  => 'orange',
        'href'   => route('sektor.index'),
        'delay'  => 3,
    ])
</div>

{{-- Chart + Map --}}
<div class="row g-3">
    <div class="col-12 col-lg-5" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="fas fa-chart-donut me-2 text-primary"></i>Status Detail Laporan</h5>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center" style="min-height:340px;">
                <div id="chart" style="width:100%;"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7" data-aos="fade-up" data-aos-delay="150">
        <div class="card h-100">
            <div class="card-header">
                <h5><i class="fas fa-map-marker-alt me-2 text-danger"></i>Peta Sebaran Gedung</h5>
            </div>
            <div class="card-body p-0" style="border-radius: 0 0 16px 16px; overflow:hidden;">
                <div id="map" style="height: 380px; width:100%;"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Donut chart
    var chartOptions = {
        chart: {
            type: 'donut',
            height: 300,
            fontFamily: 'Inter, sans-serif',
            toolbar: { show: false },
        },
        series: [{{ $menunggu }}, {{ $survey }}, {{ $acc }}, {{ $pelaporansselesai }}, {{ $tolak }}],
        labels: ['Menunggu Survey', 'Menunggu Acc', 'Pengerjaan', 'Laporan Selesai', 'Laporan Ditolak'],
        colors: ['#94a3b8', '#facc15', '#60a5fa', '#22c55e', '#ef4444'],
        legend: {
            position: 'bottom',
            fontSize: '13px',
            fontFamily: 'Inter, sans-serif',
            offsetY: 4,
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '55%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: '#64748b',
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) { return Math.round(val) + '%'; },
            style: { fontSize: '12px', fontFamily: 'Inter, sans-serif' },
        },
        stroke: { width: 2 },
        tooltip: { style: { fontSize: '13px', fontFamily: 'Inter, sans-serif' } },
    };

    var chart = new ApexCharts(document.querySelector('#chart'), chartOptions);
    chart.render();

    // Leaflet map
    var map = L.map('map').setView([-7.2575, 112.7521], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
    }).addTo(map);

    var blueIcon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
        iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34]
    });

    @foreach ($gedungs as $g)
        L.marker([{{ $g->latitude }}, {{ $g->longitude }}], { icon: blueIcon })
            .addTo(map)
            .bindPopup("<b>{{ $g->nama_gedung }}</b><br>{{ $g->alamat_gedung }}");
    @endforeach
});
</script>

@endsection
