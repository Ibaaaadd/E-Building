@extends('layouts.nav2')
@push('style')
<style>
    :root {
        --primary-color: #f97316;
        --content-bg: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    section.gedung-detail {
        margin-top: 100px;
        padding: 60px 20px;
        min-height: calc(100vh - 100px);
        background-color: var(--content-bg);
    }

    .gedung-detail .title {
        margin-bottom: 50px;
    }

    .gedung-detail h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .gedung-detail h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    
    .gedung-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        padding: 0;
    }

    .gedung-image-wrapper {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
    }
    
    .gedung-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gedung-image:hover {
        transform: scale(1.05);
    }
    
    .gedung-info {
        padding: 30px;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    
    .info-icon {
        color: var(--primary-color);
        font-size: 24px;
        margin-right: 15px;
        margin-top: 2px;
    }
    
    .info-content h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 5px 0;
    }
    
    .info-content p {
        font-size: 15px;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
    <section class="gedung-detail">
        <div class="container">
            <div class="text-center title" data-aos="fade-down">
                <h3>{{ $gedung->nama_gedung }}</h3>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="gedung-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="gedung-image-wrapper">
                            <img src="{{ $gedung->foto ? asset('fotoGedung/' . $gedung->foto) : asset('img/sby/bg-landing.jpg') }}"
                                class="gedung-image" alt="{{ $gedung->nama_gedung }}">
                        </div>
                        
                        <div class="gedung-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="info-content">
                                            <h4>Alamat Gedung</h4>
                                            <p>{{ $gedung->alamat_gedung ?? 'Alamat belum tersedia' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Tempat untuk info tambahan kedepannya seperti Status, Luas, dll -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
