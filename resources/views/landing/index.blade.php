@extends('layouts.nav')
@push('style')
    <style>
        :root {
            --primary-color: #f97316;
            --primary-dark: #ea6c00;
            --sidebar-bg: #0f172a;
            --content-bg: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        }

        body {
            min-height: 200vh;
            background: var(--content-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ===== HERO SECTION ===== */
        header.masthead {
            padding: 0;
            text-align: center;
            color: white;
            background: linear-gradient(135deg, var(--sidebar-bg) 0%, #1e3a5f 100%);
            background-image: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 58, 95, 0.95) 100%), url("img/sby/bg-landing.jpg");
            background-attachment: fixed;
            background-position: center center;
            background-size: cover;
            width: 100%;
            min-height: 100vh;
            height: auto;
            overflow: hidden;
            position: relative;
            margin-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header.masthead::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85) 0%, rgba(30, 58, 95, 0.85) 100%);
            z-index: 1;
        }

        header.masthead .container {
            position: relative;
            z-index: 2;
            padding: 60px 20px;
        }

        header.masthead .masthead-subheading {
            font-size: 1.25rem;
            font-weight: 500;
            line-height: 1.6;
            margin-bottom: 16px;
            opacity: 0.95;
            letter-spacing: 0.5px;
        }

        header.masthead .masthead-heading {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 32px;
            letter-spacing: -0.5px;
        }

        header.masthead .btn-block {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            cursor: pointer;
            padding: 14px 40px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        header.masthead .btn-block:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.4);
            color: white;
        }

        @media (min-width: 768px) {
            header.masthead .masthead-subheading {
                font-size: 1.5rem;
            }

            header.masthead .masthead-heading {
                font-size: 4.5rem;
            }
        }

        @media (max-width: 768px) {
            header.masthead .masthead-heading {
                font-size: 2.5rem;
            }

            header.masthead .masthead-subheading {
                font-size: 1.1rem;
            }
        }

        /* ===== SEKTOR SECTION ===== */
        section.sektor {
            padding: 60px 20px;
            background: var(--content-bg);
        }

        section.sektor .container {
            margin-right: auto;
            margin-left: auto;
            max-width: 1200px;
        }

        section.sektor .title {
            margin-bottom: 50px;
        }

        section.sektor h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            position: relative;
            display: inline-block;
        }

        section.sektor h3::after {
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

        .sektor-item {
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

        .image-block-inner h4 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            padding: 16px;
            margin: 0;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            transition: color 0.3s ease;
        }

        .image-block-inner:hover h4 {
            color: var(--primary-color);
        }

        .sektor a {
            color: var(--text-primary);
            text-decoration: none;
        }

        .sektor a:hover {
            text-decoration: none;
        }

        /* ===== PAGINATION ===== */
        .sektor .pagination {
            margin-top: 40px;
            justify-content: center;
        }

        .sektor .pagination>li>a,
        .sektor .pagination>li>span {
            background-color: white;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 8px 12px;
            border-radius: 6px;
            margin: 0 4px;
            transition: all 0.2s ease;
        }

        .sektor .pagination>li>a:hover,
        .sektor .pagination>li>a:focus {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .sektor .pagination>.active>a,
        .sektor .pagination>.active>span {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .sektor .pagination>.active>a:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* ===== SMOOTH ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        section.sektor {
            animation: fadeInUp 0.6s ease-out;
        }

        @media (max-width: 768px) {
            .image-block {
                grid-template-columns: 1fr;
            }

            section.sektor h3 {
                font-size: 1.75rem;
            }

            section.sektor {
                padding: 40px 16px;
            }
        }
    </style>
@endpush
@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">
                Selamat Datang di E-Building!
            </div>
            <div class="masthead-heading text-uppercase">
                Sistem Penilaian Bangunan Gedung
            </div>
            <a class="btn-block" href="#services">Pelajari Lebih Lanjut</a>
        </div>
    </header>

    <section class="sektor" id="services">
        <div class="container">
            <div class="text-center title">
                <h3>{{ $data_title }}</h3>
            </div>
            <ul class="image-block list-unstyled">
                @foreach ($data as $item)
                    @php
                        $id = $item->id;
                        $foto =
                            $item->foto == '' ? asset('img/sby/bg-landing.jpg') : asset('fotoSektor/' . $item->foto);
                    @endphp
                    <li class="sektor-item">
                        <div class="image-block-inner">
                            <a href="{{ route('beranda.sektor', [$id]) }}" class="position-relative">
                                <img class="img-responsive" src="{{ $foto }}" alt="{{ $item->nama }}"
                                    loading="lazy">
                            </a>
                            <h4>{{ $item->nama }}</h4>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
