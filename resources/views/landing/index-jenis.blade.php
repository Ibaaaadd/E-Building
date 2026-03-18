@extends('layouts.nav2')
@push('style')
<style>
    :root {
        --primary-color: #f97316;
        --primary-dark: #ea6c00;
        --content-bg: #f1f5f9;
        --text-primary: #1e293b;
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    section.jenis {
        margin-top: 100px;
        padding: 60px 20px;
        min-height: calc(100vh - 100px);
        background-color: var(--content-bg);
    }

    .jenis .container {
        margin-right: auto;
        margin-left: auto;
        max-width: 1200px;
    }

    .jenis .title {
        margin-bottom: 50px;
    }

    .jenis h3 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .jenis h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    .image-block {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .jenis-item {
        padding: 0 !important;
    }

    .image-block-inner {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .image-block-inner:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }

    .image-block-inner>a {
        display: block;
        overflow: hidden;
        flex: 1;
    }

    .image-block-inner img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .image-block-inner:hover img {
        transform: scale(1.08);
    }

    .hp-posts-cat {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        padding: 20px;
        margin: 0;
        display: block;
        text-align: center;
        transition: color 0.3s ease;
    }

    .image-block-inner:hover .hp-posts-cat {
        color: var(--primary-color);
    }

</style>
@endpush
@section('content')
    <section class="jenis pt-0">
        <div class="container mt-md-5">
            <div class="text-center title" data-aos="fade-up">
                <h3>{{ $data_title }}</h3>
            </div>
            
            @if($data->count() > 0)
            <ul class="image-block list-unstyled">
                @foreach($data as $key => $value)
                <li class="jenis-item" data-aos="fade-up" data-aos-delay="{{ $key * 100 }}">
                    <div class="image-block-inner">
                        <a href="{{ route('beranda.gedung', [$value->id]) }}" class="position-relative">
                            <img src="{{ $value->foto ? asset('fotoGedung/' . $value->foto) : asset('img/sby/bg-landing.jpg') }}" 
                                alt="{{ $value->nama }}" class="img-responsive" loading="lazy">
                        </a>
                        <span class="hp-posts-cat">{{ $value->nama }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center mt-5" data-aos="fade-up">
                <img src="{{ asset('img/sby/dprkpp logo.png') }}" width="120" style="opacity: 0.5" class="mb-3">
                <h4 style="color: #64748b">Belum ada data gedung untuk jenis ini.</h4>
            </div>
            @endif
        </div>
    </section>
@endsection
