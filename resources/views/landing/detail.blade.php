@extends('layouts.nav2')

<head>

    <style>
        section {
            margin-top: 150px;
        }

        .about .content h2 {
            font-weight: 700;
            font-size: 48px;
            line-height: 60px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .about .content h3 {
            font-weight: 500;
            line-height: 32px;
            font-size: 24px;
        }

        .about .content ul {
            list-style: none;
            padding: 0;
        }

        .about .content ul li {
            padding: 10px 0 0 28px;
            position: relative;
        }

        .about .content ul i {
            left: 0;
            top: 7px;
            position: absolute;
            font-size: 20px;
            color: #01b1d7;
        }

        .about .content p:last-child {
            margin-bottom: 0;
        }

        /*--------------------------------------------------------------
# About List
--------------------------------------------------------------*/
        .about-list {
            padding-top: 0;
        }

        .about-list .icon-box h4 {
            font-size: 20px;
            font-weight: 700;
            margin: 5px 0 10px 60px;
        }

        .about-list .icon-box i {
            font-size: 48px;
            float: left;
            color: #01b1d7;
        }

        .about-list .icon-box p {
            font-size: 18px;
            color: #848484;
            margin-left: 60px;
        }

        .about-list .image {
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 400px;
        }
    </style>
</head>
<section id="about" class="about-list">
    <div class="text-center title">
        <h3 style="font-size: 36px;font-weight: 700;">Pasar Ikan</h3>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img src="https://static.vecteezy.com/system/resources/thumbnails/001/849/553/small_2x/modern-gold-background-free-vector.jpg"
                    class="img-fluid" alt="">
            </div>
            <div class="card col-lg-6 pt-4 pt-lg-0 content">

                <div class="icon-box mt-5 mt-lg-0">
                    <i class='bx bxs-chevrons-right'></i>

                    <p>Alamat : jl. jimerto</p>
                </div>
            </div>
        </div>
    </div>


</section>
