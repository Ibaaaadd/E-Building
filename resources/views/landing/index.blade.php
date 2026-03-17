@extends('layouts.nav')
@push('style')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {

            min-height: 200vh;
        }

    

        header.masthead {
            padding-top: 10.5rem;
            padding-bottom: 6rem;
            text-align: center;
            color: white;
            background-image: url("img/sby/bg-landing.jpg");
            background-repeat: no-repeat;
            background-attachment: scroll;
            background-position: center center;
            background-size: cover;
            width: 100%;
            min-height: 100vh;
            height: auto;
            overflow: hidden;
            position: relative;
            padding: 0;
            margin-top: 0;
        }

        header.masthead .masthead-subheading {
            opacity: 100%;
            font-size: 1.5rem;
            font-style: italic;
            line-height: 1.5rem;
            margin-bottom: 25px;
            font-family: "Roboto Slab", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        header.masthead .masthead-heading {
            font-size: 3.25rem;
            font-weight: 700;
            line-height: 3.25rem;
            margin-bottom: 2rem;
            font-family: "Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        @media (min-width: 768px) {
            header.masthead {
                padding-top: 17rem;
                padding-bottom: 12.5rem;
            }

            header.masthead .masthead-subheading {
                font-size: 2.25rem;
                font-style: italic;
                line-height: 2.25rem;
                margin-bottom: 2rem;
            }

            header.masthead .masthead-heading {
                font-size: 4.5rem;
                font-weight: 700;
                line-height: 4.5rem;
                margin-bottom: 4rem;
            }
        }

        @media (max-width: 768px) {
            header.masthead {
                padding-top: 15rem;
                padding-bottom: 12.5rem;
            }
        }

        .sektor .container {
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
        }

        .sektor .image-block {
            margin-top: 24px;
            display: flex;
            flex-wrap: wrap;
        }


        .sektor .image-block li>.image-block-inner {
            height: 95%;
        }

        .sektor a {
            color: #111;
            text-decoration: none;
        }



        .btn-block {
            text-decoration: none;
            cursor: pointer;
            background-color: #f0cb8a;
            color: black;
            width: 50%;


        }


        .sektor h2,
        h4 a {
            /* text-transform: uppercase; */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .sektor h3 {
            font-size: 32px;
            font-weight: 700;
        }

        .sektor a:hover {
            text-decoration: none;
        }

        .sektor .img-responsive {
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .image-block-inner:hover h4  {
            color: #3E58A7;
            /* Warna teks saat dihover */
        }

        .image-block-inner:hover img {
            transform: scale(1.1);
        }

        .sektor .image-block li>.image-block-inner>a {
            border-radius: 10px;
            display: block;
            overflow: hidden;
        }

        .sektor .image-block li>.image-block-inner>a img {
            border: 1px solid #e1e1df;
            position: relative;
            overflow: hidden;
        }


        .sektor .hp-posts-cat {
            margin-bottom: 8px;
            margin-top: 20px;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.1rem;
            display: inline-block;
        }

        .sektor {
            font-family: 'Oswald', sans-serif;
        }

        .sektor .image-block li>.image-block-inner h4,
        .hp-posts-cat,
        .sektor .image-block li>.image-block-inner p,
        .read-more {
            display: table-cell;
            vertical-align: bottom;
            padding: 0 28px;
        }

        .read-more {
            display: block;
            text-decoration: underline;
            margin-top: 30px;
            font-weight: 600;
        }

        .sektor .pagination>li>a {
            background-color: white;
            color: #000000;
        }

        .sektor .pagination>li>a:focus,
        .sektor .pagination>li>a:hover,
        .sektor .pagination>li>span:focus,
        .sektor .pagination>li>span:hover {
            color: #5a5a5a;
            background-color: #eee;
            border-color: #ddd;
        }

        .sektor .pagination>.active>a {
            color: white;
            background-color: #2c588f !Important;
            border: solid 1px #2c588f !Important;
        }

        .sektor .pagination>.active>a:hover {
            background-color: #2c588f !Important;
            border: solid 1px #2c588f;
        }
    </style>
@endpush
@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Welcome To E-Bulding!</div>
            <div class="masthead-heading text-uppercase">It's Nice To Meet You</div>
            <a class="btn-block btn-primary btn-lg btn-xl text-uppercase" href="#services">Tell Me More</a>
        </div>
    </header>

    <section class="sektor pt-0" style="background-color:whitesmoke">
        <div class="container mt-md-5">
            <div class="text-center title">
                <h3 class="mx-4 my-0 text-center">{{ $data_title }}</h3>
            </div>
            <ul class="row d-lg-flex list-unstyled image-block justify-content-center px-lg-0 mx-lg-0">
                @foreach ($data as $item)
                    @php
                        $id = $item->id;
                    @endphp
                    <li class="col-lg-3 col-md-5 image-block full-width p-3 sektor-item">
                        <div class="image-block-inner" style="border-radius:10px;">
                            <h4 class="mt-3">{{ $item->nama }}</h4>
                            <a class="mh-100" href="{{ route('beranda.sektor', [$id]) }}">
                                <img class="img-responsive w-100" 
                                    src="{{ $item->foto == '' ? asset('img/sby/bg-landing.jpg') : asset('fotoSektor/' . $item->foto) }}" 
                                    alt="{{ $item->nama }}">
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        {{-- <div class="text-center">
            <a class="btn" href="{{ url('sektor') }}" role="button" style="background:#2c588f;color:white;border-radius:40px;">Lihat Semua Sektor</a>
        </div> --}}
    </section>
@endsection