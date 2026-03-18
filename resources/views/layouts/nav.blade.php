<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eBuilding</title>
    <link rel="shortcut icon" href="{{ asset('img/sby/dprkpp logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
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
            z-index: 10000;
        }
  
        nav.sticky {
            padding: 15px 100px;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
  
        nav .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: 0.6s;
        }

        nav .logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 700;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 40%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.5px;
        }
  
        nav ul {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
  
        nav ul li {
            position: relative;
            list-style: none;
        }
  
        nav ul li a {
            position: relative;
            margin: 0 15px;
            text-decoration: none;
            color: #fff;
            letter-spacing: 1px;
            font-weight: 600;
            transition: 0.3s;
            padding: 8px 24px;
            border-radius: 20px;
        }
        
        nav ul li a:hover {
            background-color: #f97316;
            color: #fff;
        }
  
        nav.sticky li a {
            color: #1e293b;
        }
  </style>
  @stack('style')
</head>
<body>
    <nav data-aos="fade-down" data-aos-duration="800">
        <a href="#" class="logo">
            <img src="{{ asset('img/sby/dprkpp logo.png') }}" alt="Logo">
            <span class="logo-text">eBuilding</span>
        </a>
        <ul>
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif
        </ul>
    </nav>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });
        window.addEventListener('scroll', function() {
            let header = document.querySelector('nav');
            header.classList.toggle('sticky', window.scrollY > 50);
        });
    </script>
</body>
</html>