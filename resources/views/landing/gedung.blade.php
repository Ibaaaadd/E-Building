@extends('layouts.nav2')
<head>
    <style>
section {
    margin-top: 150px;
}

.jenis .container {
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}

.jenis .image-block {
    margin-top: 24px;
    display: flex;
    flex-wrap: wrap;
}

.jenis .image-block-inner {
    border-radius: 10px;
    box-shadow: 0px 3px 10px 1px rgba(204, 204, 204, 1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.jenis .image-block li>.image-block-inner {
    padding-bottom: 20px;
    background-color: #fff;
    height: 100%;
}

.jenis a {
    color: #111;
    text-decoration: none;
}

.jenis h2,
.jenis h4 a {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.jenis h3 {
    font-size: 32px;
    font-weight: 700;
}

.jenis .img-responsive {
       height: 200px; 
    width: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    position: relative;
    overflow: hidden;
}

.jenis .image-block-inner:hover {
    box-shadow: 0px 6px 15px 2px rgba(204, 204, 204, 1);
}

.jenis .image-block-inner:hover h4 {
    color: #3E58A7; /* Warna teks saat dihover */
}

.jenis .image-block-inner:hover img {
    transform: scale(1.1);
}

.jenis .image-block li>.image-block-inner>a {
    border-radius: 10px;
    display: block;
    overflow: hidden;
}

.jenis .image-block li>.image-block-inner>a img {
  
    border: 1px solid #e1e1df;
    position: relative;
    overflow: hidden;
}

.jenis .hp-posts-cat {
    margin-bottom: 8px;
    margin-top: 20px;
    text-transform: uppercase;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.1rem;
    display: inline-block;
}

.jenis {
    font-family: 'Oswald', sans-serif;
}

.jenis .image-block li>.image-block-inner h4,
.hp-posts-cat,
.jenis .image-block li>.image-block-inner p,
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

.jenis .pagination > li > a {
    background-color: white;
    color: #000000;
}

.jenis .pagination > li > a:focus,
.jenis .pagination > li > a:hover,
.jenis .pagination > li > span:focus,
.jenis .pagination > li > span:hover {
    color: #5a5a5a;
    background-color: #eee;
    border-color: #ddd;
}

.jenis .pagination > .active > a {
    color: white;
    background-color: #2c588f !important;
    border: solid 1px #2c588f !important;
}

.jenis .pagination > .active > a:hover {
    background-color: #2c588f !important;
    border: solid 1px #2c588f;
}



    </style>
</head>
<body >
    <section class="jenis pt-0">
        <div class="container mt-md-5">
          <div class="text-center title">
            <h3 class="mx-4 my-0 text-center">Pasar</h3>
          </div>
          <ul class="row d-lg-flex list-unstyled image-block justify-content-center px-lg-0 mx-lg-0">
  
            <li class="col-lg-3 col-md-5 image-block full-width p-3 jenis-item">
                <div class="image-block-inner" style="border-radius:25px;">
                  <a class="mh-100" href="">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/001/849/553/small_2x/modern-gold-background-free-vector.jpg" alt="penting memilih produk asuransi jiwa dengan eats" class="img-responsive w-100" style="border-top-left-radius: 25px;border-top-right-radius: 25px;height:200px;">
                  </a>
                  <span class="hp-posts-cat">jenis</span>
                  <h4 class="mt-3"><a href="" style="font-size:20px;margin-bottom:1px;">Jl.simokerto</a></h4>
                  <!--  <p></p> -->
                  <a href="" class="read-more" style="color:#2c588f;">Detail »</a>
                </div><!-- .image-block-inner -->
              </li>
    
  
            <li class="col-lg-3 col-md-5 image-block full-width p-3 jenis-item">
              <div class="image-block-inner" style="border-radius:25px;">
                <a class="mh-100" href="">
                  <img src="https://static.vecteezy.com/system/resources/thumbnails/001/849/553/small_2x/modern-gold-background-free-vector.jpg" alt="penting memilih produk asuransi jiwa dengan eats" class="img-responsive w-100" style="border-top-left-radius: 25px;border-top-right-radius: 25px;height:200px;">
                </a>
                <span class="hp-posts-cat">jenis</span>
                <h4 class="mt-3"><a href="" style="font-size:20px;margin-bottom:1px;">Jl.simokerto</a></h4>
                <!--  <p></p> -->
                <a href="" class="read-more" style="color:#2c588f;">Detail »</a>
              </div><!-- .image-block-inner -->
            </li>
  
            <li class="col-lg-3 col-md-5 image-block full-width p-3 jenis-item">
                <div class="image-block-inner" style="border-radius:25px;">
                  <a class="mh-100" href="">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/001/849/553/small_2x/modern-gold-background-free-vector.jpg" alt="penting memilih produk asuransi jiwa dengan eats" class="img-responsive w-100" style="border-top-left-radius: 25px;border-top-right-radius: 25px;height:200px;">
                  </a>
                  <span class="hp-posts-cat">jenis</span>
                  <h4 class="mt-3"><a href="" style="font-size:20px;margin-bottom:1px;">Jl.simokerto</a></h4>
                  <!--  <p></p> -->
                  <a href="" class="read-more" style="color:#2c588f;">Detail »</a>
                </div><!-- .image-block-inner -->
              </li>
    
  
              <li class="col-lg-3 col-md-5 image-block full-width p-3 jenis-item">
                <div class="image-block-inner" style="border-radius:25px;">
                  <a class="mh-100" href="">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/001/849/553/small_2x/modern-gold-background-free-vector.jpg" alt="penting memilih produk asuransi jiwa dengan eats" class="img-responsive w-100" style="border-top-left-radius: 25px;border-top-right-radius: 25px;height:200px;">
                  </a>
                  <span class="hp-posts-cat">jenis</span>
                  <h4 class="mt-3"><a href="" style="font-size:20px;margin-bottom:1px;">Jl.simokerto</a></h4>
                  <!--  <p></p> -->
                  <a href="" class="read-more" style="color:#2c588f;">Detail »</a>
                </div><!-- .image-block-inner -->
              </li>
    
  
  
          </ul>
        </div>
              </section>

      {{-- perulangan --}}

      {{-- <section class="jenis pt-0">
        <div class="container mt-md-5">
          <div class="text-center title">
            <h3 class="mx-4 my-0 text-center">Jenis Ekonomi</h3>
          </div>
          <ul class="row d-lg-flex list-unstyled image-block justify-content-center px-lg-0 mx-lg-0">
            @foreach($data_items as $item)
            <li class="col-lg-3 col-md-5 image-block full-width p-3 jenis-item">
              <div class="image-block-inner" style="border-radius: 25px;">
                <a class="mh-100" href="{{ $item['link'] }}">
                  <img src="{{ $item['img_src'] }}" alt="gambar" class="img-responsive w-100"
                    style="border-top-left-radius: 25px; border-top-right-radius: 25px; height: 200px;">
                </a>
                <span class="hp-posts-cat">jenis</span>
                <h4 class="mt-3"><a href="{{ $item['link'] }}"
                    style="font-size: 20px; margin-bottom: 1px;">{{ $item['title'] }}</a></h4>
                <!--  <p></p> -->
                <a href="{{ $item['link'] }}" class="read-more" style="color: #2c588f;">Detail »</a>
              </div><!-- .image-block-inner -->
            </li>
            @endforeach
          </ul>
        </div>
        <div class="text-center">
          <a class="btn" href="https://mediainovasi.id/jenis.php" role="button"
            style="background: #2c588f; color: white;">Lihat Semua jenis</a>
        </div>
      </section> --}}


</body>
