<!DOCTYPE html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
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

        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.6s;
            padding: 20px 100px;
            /* Adjusted padding */
            z-index: 10000;
            background-color: #f8f9fa;
            /* Added background color */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Added shadow */
        }

        nav.sticky {
            padding: 10px 100px;
            /* Adjusted padding */
            background: #fff;
        }

        nav .logo {
            position: relative;
            font-weight: 700;
            color: #000000;
            text-decoration: none;
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.6s;
        }

        nav ul {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul li {
            position: relative;
            list-style: none;
        }

        nav ul li a {
            position: relative;
            margin: 0 15px;
            text-decoration: none;
            color: #0d0d0d;
            letter-spacing: 2px;
            font-weight: 500;
            transition: 0.3s;
            /* Adjusted transition */
            padding: 8px 15px;
            /* Added padding */
            border-radius: 20px;
            /* Rounded corners */
        }

        nav ul li a:hover {
            background-color: #007bff;
            /* Added hover background color */
            color: #fff;
            /* Added hover text color */
        }

        nav.sticky .logo,
        nav.sticky li a {
            color: #000;
        }
    </style>
    @stack('style')

</head>

<body>
    <nav>
        <a href="#" class="logo">
            <image class="contoh" src="https://ebuilding.dprkpp.web.id//images/logo.png">
        </a>
        <ul>
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif
        </ul>
    </nav>
    @yield('content')
    <script>
        window.addEventListener('scroll', function() {
            var logo = document.querySelector('.contoh'); // Memilih elemen logo berdasarkan kelas
            if (window.scrollY > 100) { // Angka 50 bisa disesuaikan sesuai kebutuhan
                logo.src = 'https://ebuilding.dprkpp.web.id//images/logo.png'; // Path logo saat discroll
            } else {
                logo.src = 'https://ebuilding.dprkpp.web.id//images/logo.png'; // Path logo awal
            }
        });

        window.addEventListener('scroll', function() {
            let header = document.querySelector('nav');
            header.classList.toggle('sticky', window.scrollY > 100);
        });
    </script>
</body>

</html>
