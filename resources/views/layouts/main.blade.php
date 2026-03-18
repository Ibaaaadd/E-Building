<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Building</title>

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.5.1-web/css/all.min.css') }}">

    <link rel="shortcut icon" href="{{ asset('img/sby/dprkpp logo.png') }}" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap Datepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- ApexCharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- AOS (Animate on Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Vite assets -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active: #f97316;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --topbar-height: 64px;
            --topbar-bg: #ffffff;
            --content-bg: #f1f5f9;
            --accent: #f97316;
            --accent-dark: #ea6c00;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--content-bg);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, width 0.3s ease;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 72px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 16px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            height: var(--topbar-height);
            text-decoration: none;
            overflow: hidden;
        }

        .sidebar-logo img {
            width: 34px;
            height: 34px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-size: 17px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            max-width: 180px;
            transition: max-width 0.3s ease, opacity 0.2s ease;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 40%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        #sidebar.collapsed .sidebar-logo { justify-content: center; gap: 0; padding: 0; }
        #sidebar.collapsed .sidebar-logo-text { max-width: 0; opacity: 0; pointer-events: none; }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #475569;
            padding: 12px 20px 4px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }

        #sidebar.collapsed .nav-section-label { opacity: 0; max-height: 0; padding: 0; overflow: hidden; }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.15s, color 0.15s, padding 0.3s;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
        }

        #sidebar.collapsed .sidebar-nav a {
            padding: 10px 0;
            justify-content: center;
        }

        .sidebar-nav a:hover {
            background: var(--sidebar-hover);
            color: #e2e8f0;
        }

        .sidebar-nav a.active {
            background: rgba(249, 115, 22, 0.12);
            color: #fb923c;
            border-right: 3px solid var(--accent);
        }

        .sidebar-nav a .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav a .nav-label {
            overflow: hidden;
            max-width: 200px;
            transition: max-width 0.3s ease, opacity 0.2s ease;
        }

        #sidebar.collapsed .sidebar-nav a .nav-label { max-width: 0; opacity: 0; }

        /* ===== TOPBAR ===== */
        #topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--topbar-bg);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 24px;
            z-index: 999;
            transition: left 0.3s ease;
            gap: 12px;
        }

        #topbar.sidebar-collapsed {
            left: 72px;
        }

        .topbar-toggle {
            background: none;
            border: none;
            color: #64748b;
            font-size: 18px;
            cursor: pointer;
            padding: 6px 8px;
            border-radius: 8px;
            transition: background 0.15s;
            flex-shrink: 0;
        }

        .topbar-toggle:hover { background: #f1f5f9; }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
            flex: 1;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-greeting {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .topbar-greeting span {
            color: #1e293b;
            font-weight: 600;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .topbar-dropdown .dropdown-toggle {
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .topbar-dropdown .dropdown-toggle::after { display: none; }

        .topbar-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            border-radius: 12px;
            min-width: 180px;
            padding: 6px;
        }

        .topbar-dropdown .dropdown-item {
            border-radius: 8px;
            font-size: 13px;
            padding: 8px 12px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .topbar-dropdown .dropdown-item:hover { background: #f8fafc; }

        .topbar-dropdown .dropdown-item.text-danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* ===== MAIN CONTENT ===== */
        #main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 28px 28px 40px;
            min-height: calc(100vh - var(--topbar-height));
            transition: margin-left 0.3s ease;
        }

        #main-content.sidebar-collapsed {
            margin-left: 72px;
        }

        /* ===== CARD ===== */
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04) !important;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 18px 24px !important;
            border-radius: 16px 16px 0 0 !important;
        }

        .card-header h5, .card-header h4 {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
        }

        /* ===== TABLE ===== */
        .table {
            font-size: 13.5px;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            color: #374151;
            border-color: #f1f5f9;
        }

        .table tbody tr:hover { background: #f8fafc; }

        /* ===== BUTTONS ===== */
        .btn { border-radius: 8px !important; font-size: 13px !important; font-weight: 500 !important; }
        .btn-primary { background: var(--accent) !important; border-color: var(--accent) !important; }
        .btn-primary:hover { background: var(--accent-dark) !important; border-color: var(--accent-dark) !important; }

        /* ===== PAGE HEADER ===== */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .page-header p {
            font-size: 13px;
            color: #94a3b8;
            margin: 4px 0 0;
        }

        /* ===== PAGINATION ===== */
        ul.pagination {
            display: flex;
            justify-content: flex-end;
        }

        .page-link { font-size: 13px; border-radius: 8px; }

        /* ===== MOBILE ===== */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width) !important;
            }
            #sidebar.mobile-open {
                transform: translateX(0);
            }
            #topbar { left: 0; }
            #main-content { margin-left: 0; }
            .sidebar-overlay {
                display: block !important;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
        }

        /* ===== CUSTOM APP TABLE ===== */
        .card-table-body { padding: 0 !important; overflow: hidden; }
        .apptbl-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .apptbl .table { margin: 0 !important; }

        /* Toolbar */
        .apptbl-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 13px 18px 11px; gap: 10px; flex-wrap: wrap;
            background: #fff; border-bottom: 1px solid #f1f5f9;
        }
        .apptbl-length-label {
            display: flex; align-items: center; gap: 7px;
            font-size: 12.5px; font-weight: 500; color: #64748b; white-space: nowrap;
        }
        .apptbl-per {
            border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 5px 26px 5px 10px; font-size: 12.5px; color: #374151;
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'%3E%3Cpath fill='%2394a3b8' d='M0 0l4.5 5L9 0z'/%3E%3C/svg%3E") no-repeat right 9px center;
            -webkit-appearance: none; appearance: none; outline: none; cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .apptbl-per:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(249,115,22,0.12); }
        .apptbl-search-box { position: relative; display: flex; align-items: center; }
        .apptbl-search-box svg {
            position: absolute; left: 9px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .apptbl-search {
            border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 5.5px 11px 5.5px 30px; font-size: 12.5px; color: #374151;
            width: 200px; outline: none; background: #fff;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s, width 0.2s ease;
        }
        .apptbl-search::placeholder { color: #c0cad8; }
        .apptbl-search:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(249,115,22,0.12); width: 240px; }

        /* Sort icons */
        .apptbl-si {
            display: inline-block; margin-left: 4px; font-style: normal;
            font-size: 10px; color: #c8d4e0; line-height: 1; transition: color 0.15s;
        }
        .apptbl-si.asc, .apptbl-si.desc { color: var(--accent); }
        thead th:has(.apptbl-si) { cursor: pointer; white-space: nowrap; }
        thead th:has(.apptbl-si):hover .apptbl-si { color: #94a3b8; }

        /* Table cells inside apptbl */
        .card-table-body .table thead th { padding: 10px 14px; }
        .card-table-body .table tbody td { padding: 10px 14px; vertical-align: middle; }

        /* Footer */
        .apptbl-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 9px 18px; background: #fafbfc;
            border-top: 1px solid #f1f5f9; border-radius: 0 0 16px 16px;
            flex-wrap: wrap; gap: 8px;
        }
        .apptbl-info { font-size: 12px; color: #94a3b8; }

        /* Pagination */
        .apptbl-pages { display: flex; align-items: center; gap: 2px; }
        .apptbl-pb {
            min-width: 28px; height: 28px; padding: 0 5px;
            border: none; background: transparent; border-radius: 7px;
            font-size: 13px; color: #64748b; cursor: pointer; line-height: 1;
            display: inline-flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif; transition: background 0.15s, color 0.15s;
            user-select: none;
        }
        .apptbl-pb:hover:not(.off):not(.on) { background: #f1f5f9; color: #1e293b; }
        .apptbl-pb.on { background: var(--accent); color: #fff; font-weight: 600; }
        .apptbl-pb.off { opacity: 0.35; cursor: default; pointer-events: none; }

        /* Thumbnail inside table rows */
        .table-thumb {
            width: 40px; height: 40px; object-fit: cover;
            border-radius: 8px; cursor: pointer; border: 2px solid #e2e8f0;
            transition: transform 0.15s, box-shadow 0.15s; display: block;
        }
        .table-thumb:hover { transform: scale(1.08); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

        /* ===== ACTION BUTTONS ===== */
        .btn-icon {
            display: inline-flex !important; align-items: center; justify-content: center;
            width: 30px; height: 30px; padding: 0 !important;
            border-radius: 7px !important; font-size: 12px !important;
            font-weight: 400 !important; border: none; cursor: pointer;
            transition: background 0.15s, color 0.15s, transform 0.1s;
        }
        .btn-icon:active { transform: scale(0.92); }
        .btn-icon-edit   { background: #fef3c7; color: #d97706; }
        .btn-icon-edit:hover { background: #fde68a; color: #b45309; }
        .btn-icon-delete { background: #fee2e2; color: #dc2626; }
        .btn-icon-delete:hover { background: #fecaca; color: #b91c1c; }
        .btn-icon-info   { background: #dbeafe; color: #2563eb; }
        .btn-icon-info:hover { background: #bfdbfe; color: #1d4ed8; }
        .btn-icon-map    { background: #dcfce7; color: #16a34a; }
        .btn-icon-map:hover { background: #bbf7d0; color: #15803d; }
        .btn-icon-view   { background: #f0fdf4; color: #15803d; }
        .btn-icon-view:hover { background: #dcfce7; color: #166534; }
        .btn-icon-pdf    { background: #fff1f2; color: #e11d48; }
        .btn-icon-pdf:hover { background: #ffe4e6; color: #be123c; }
        .actions-cell { white-space: nowrap; }
        .actions-cell .btn-icon + .btn-icon { margin-left: 3px; }

        /* ===== MODAL ===== */
        .modal-content {
            border: none !important; border-radius: 16px !important;
            box-shadow: 0 20px 60px rgba(0,0,0,0.14) !important;
        }
        .modal-header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 16px 22px !important; border-radius: 16px 16px 0 0 !important;
        }
        .modal-body { padding: 20px 22px !important; }
        .modal-footer {
            border-top: 1px solid #f1f5f9 !important;
            padding: 12px 22px !important; border-radius: 0 0 16px 16px !important;
        }
        .modal-title { font-size: 14px !important; font-weight: 600 !important; color: #1e293b; }

        /* Photo lightbox modal */
        .photo-lightbox .modal-content { background: #111 !important; }
        .photo-lightbox .modal-header {
            background: #1e293b !important; border-bottom: 1px solid #334155 !important;
        }
        .photo-lightbox .modal-title { color: #f1f5f9 !important; }
        .photo-lightbox .btn-close { filter: invert(1) brightness(1.5); }

        /* PDF viewer modal */
        .pdf-viewer .modal-header { background: #f8fafc !important; }

        /* ===== FORM CONTROLS ===== */
        .form-control, .form-select {
            border: 1px solid #e2e8f0 !important; border-radius: 8px !important;
            font-size: 13.5px; color: #374151;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1) !important;
        }
        .form-label { font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .input-group .btn { border-radius: 0 8px 8px 0 !important; }

        .badge { font-size: 11px; border-radius: 6px; font-weight: 500; }

        /* ===== SCROLLBAR SIDEBAR ===== */
        #sidebar .sidebar-nav::-webkit-scrollbar { width: 4px; }
        #sidebar .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        #sidebar .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
    </style>
</head>

<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside id="sidebar">
        <a href="{{ route('home') }}" class="sidebar-logo">
            <img src="{{ asset('img/sby/dprkpp logo.png') }}" alt="eBuilding Logo">
            <span class="sidebar-logo-text">eBuilding</span>
        </a>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>

            <a href="{{ route('home') }}" class="{{ Request::route()->getName() == 'home' ? 'active' : '' }}">
                <i class="fas fa-chart-pie nav-icon"></i>
                <span class="nav-label">Dashboard</span>
            </a>

            <a href="{{ route('pelaporan.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'pelaporan') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <span class="nav-label">Laporan</span>
            </a>

            <a href="{{ route('dinas.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'dinas') ? 'active' : '' }}">
                <i class="fas fa-building nav-icon"></i>
                <span class="nav-label">Dinas</span>
            </a>

            <a href="{{ route('gedung.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'gedung') ? 'active' : '' }}">
                <i class="fas fa-city nav-icon"></i>
                <span class="nav-label">Gedung</span>
            </a>

            <a href="{{ route('sektor.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'sektor') ? 'active' : '' }}">
                <i class="fas fa-layer-group nav-icon"></i>
                <span class="nav-label">Sektor</span>
            </a>

            <a href="{{ route('jenis.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'jenis') ? 'active' : '' }}">
                <i class="fas fa-tags nav-icon"></i>
                <span class="nav-label">Jenis</span>
            </a>

            @if (@auth()->user()->role_id == 1)
                <div class="nav-section-label">Administrator</div>

                <a href="{{ route('aspek.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'aspek') ? 'active' : '' }}">
                    <i class="fas fa-tasks nav-icon"></i>
                    <span class="nav-label">Aspek</span>
                </a>

                <a href="{{ route('indikator.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'indikator') ? 'active' : '' }}">
                    <i class="fas fa-list-check nav-icon"></i>
                    <span class="nav-label">Indikator</span>
                </a>

                <a href="{{ route('user.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'user') ? 'active' : '' }}">
                    <i class="fas fa-users-cog nav-icon"></i>
                    <span class="nav-label">Kelola User</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- ===== TOPBAR ===== -->
    <header id="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="topbar-title" id="topbar-page-title">
            @yield('page-title', 'Dashboard')
        </div>

        <div class="topbar-user">
            <div class="topbar-greeting d-none d-md-block">
                Selamat datang, <span>{{ auth()->user()->name }}</span>
            </div>

            <div class="topbar-dropdown dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/sby/surabaya logo.png') }}" alt="Avatar" class="topbar-avatar">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <span class="dropdown-item-text fw-semibold" style="font-size:13px; color:#1e293b;">
                            {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main id="main-content">
        @yield('contents')
    </main>

    <!-- ===== SCRIPTS ===== -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <!-- Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- XLSX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Init AOS
        AOS.init({ duration: 400, once: true, easing: 'ease-out-cubic' });

        // Sidebar toggle
        let sidebarCollapsed = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const topbar = document.getElementById('topbar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('mobile-open');
                overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
            } else {
                sidebarCollapsed = !sidebarCollapsed;
                sidebar.classList.toggle('collapsed', sidebarCollapsed);
                topbar.classList.toggle('sidebar-collapsed', sidebarCollapsed);
                mainContent.classList.toggle('sidebar-collapsed', sidebarCollapsed);
            }
        }

        // ===== AppTable — custom lightweight datatable =====
        (function () {
            'use strict';

            function AppTable(el, opts) {
                this.el = el;
                this.cfg = Object.assign({ per: 10, perOpts: [5, 10, 25, 50] }, opts || {});
                this._page = 1;
                this._per  = this.cfg.per;
                this._q    = '';
                this._col  = -1;
                this._dir  = 1;
                this._rows = [];
                this._filt = [];
                this._build();
            }

            AppTable.prototype._build = function () {
                var S = this, el = this.el;
                var tbody = el.querySelector('tbody');
                if (!tbody) return;

                this._rows = Array.from(tbody.querySelectorAll('tr'));
                this._filt = this._rows.slice();

                var wrap = document.createElement('div');
                wrap.className = 'apptbl';
                el.parentNode.insertBefore(wrap, el);

                var tb = document.createElement('div');
                tb.className = 'apptbl-toolbar';
                tb.innerHTML =
                    '<label class="apptbl-length-label">' +
                        '<span>Tampilkan</span>' +
                        '<select class="apptbl-per">' +
                        S.cfg.perOpts.map(function (n) {
                            return '<option value="' + n + '"' + (n === S._per ? ' selected' : '') + '>' + n + '</option>';
                        }).join('') +
                        '</select>' +
                        '<span>data</span>' +
                    '</label>' +
                    '<div class="apptbl-search-box">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">' +
                        '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>' +
                        '<input type="text" class="apptbl-search" placeholder="Cari data...">' +
                    '</div>';

                var sw = document.createElement('div');
                sw.className = 'apptbl-scroll';

                var ft = document.createElement('div');
                ft.className = 'apptbl-footer';
                ft.innerHTML = '<span class="apptbl-info"></span><div class="apptbl-pages"></div>';

                wrap.appendChild(tb);
                sw.appendChild(el);
                wrap.appendChild(sw);
                wrap.appendChild(ft);

                this._info  = ft.querySelector('.apptbl-info');
                this._pages = ft.querySelector('.apptbl-pages');

                tb.querySelector('.apptbl-per').addEventListener('change', function () {
                    S._per = parseInt(this.value); S._page = 1; S._draw();
                });
                tb.querySelector('.apptbl-search').addEventListener('input', function () {
                    S._q = this.value.toLowerCase().trim(); S._page = 1; S._filter(); S._draw();
                });

                this._sortHeaders();
                this._draw();
            };

            AppTable.prototype._sortHeaders = function () {
                var S = this;
                var skip = ['aksi','foto','koordinat','e-surat'];
                this.el.querySelectorAll('thead th').forEach(function (th, i) {
                    if (skip.indexOf(th.textContent.trim().toLowerCase()) !== -1) return;
                    var ic = document.createElement('span');
                    ic.className = 'apptbl-si'; ic.textContent = '⇅';
                    th.appendChild(ic);
                    th.addEventListener('click', function () {
                        if (S._col === i) S._dir *= -1; else { S._col = i; S._dir = 1; }
                        S.el.querySelectorAll('.apptbl-si').forEach(function (s) { s.textContent = '⇅'; s.className = 'apptbl-si'; });
                        ic.textContent = S._dir === 1 ? '↑' : '↓';
                        ic.className = 'apptbl-si ' + (S._dir === 1 ? 'asc' : 'desc');
                        S._sort(); S._draw();
                    });
                });
            };

            AppTable.prototype._filter = function () {
                var q = this._q;
                this._filt = q ? this._rows.filter(function (r) {
                    return r.textContent.toLowerCase().indexOf(q) !== -1;
                }) : this._rows.slice();
                if (this._col >= 0) this._sort();
            };

            AppTable.prototype._sort = function () {
                var col = this._col, dir = this._dir;
                this._filt.sort(function (a, b) {
                    var av = a.cells[col] ? a.cells[col].textContent.trim() : '';
                    var bv = b.cells[col] ? b.cells[col].textContent.trim() : '';
                    var an = parseFloat(av.replace(/[^0-9.-]/g, '')), bn = parseFloat(bv.replace(/[^0-9.-]/g, ''));
                    if (!isNaN(an) && !isNaN(bn)) return (an - bn) * dir;
                    return av.localeCompare(bv, 'id') * dir;
                });
            };

            AppTable.prototype._draw = function () {
                var S = this, tbody = this.el.querySelector('tbody');
                var n = this._filt.length, N = this._rows.length;
                var pages = Math.max(1, Math.ceil(n / this._per));
                if (this._page > pages) this._page = pages;
                var s = (this._page - 1) * this._per, e = Math.min(s + this._per, n);
                var visible = this._filt.slice(s, e);

                this._rows.forEach(function (r) { r.hidden = true; });
                visible.forEach(function (r) { r.hidden = false; tbody.appendChild(r); });

                var empty = tbody.querySelector('.apptbl-empty');
                if (n === 0) {
                    if (!empty) {
                        var cols = (S.el.querySelector('thead tr') || {cells:{length:1}}).cells.length;
                        empty = document.createElement('tr');
                        empty.className = 'apptbl-empty';
                        empty.innerHTML = '<td colspan="' + cols + '" style="text-align:center;padding:32px 0;color:#94a3b8;font-size:13px;font-style:italic;">Tidak ada data yang ditemukan</td>';
                        tbody.appendChild(empty);
                    }
                } else if (empty) empty.remove();

                this._info.textContent = n === 0 ? '' :
                    (s + 1) + '–' + e + ' dari ' + n +
                    (S._q && n !== N ? ' (filter dari ' + N + ')' : '');

                this._drawPages(pages);
            };

            AppTable.prototype._drawPages = function (pages) {
                var S = this, cur = this._page, pg = this._pages;
                pg.innerHTML = '';
                if (pages <= 1) return;

                function mkBtn(html, page, cls) {
                    var b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'apptbl-pb' + (cls ? ' ' + cls : '');
                    b.innerHTML = html;
                    if (page !== null) b.addEventListener('click', function () { S._page = page; S._draw(); });
                    return b;
                }
                function mkEllipsis() {
                    var sp = document.createElement('span');
                    sp.className = 'apptbl-pb off'; sp.textContent = '…'; return sp;
                }

                pg.appendChild(mkBtn('&laquo;', cur > 1 ? 1       : null, cur === 1     ? 'off' : ''));
                pg.appendChild(mkBtn('&lsaquo;', cur > 1 ? cur - 1 : null, cur === 1     ? 'off' : ''));

                var lo = Math.max(1, cur - 2), hi = Math.min(pages, cur + 2);
                if (lo > 1) { pg.appendChild(mkBtn(1, 1, '')); if (lo > 2) pg.appendChild(mkEllipsis()); }
                for (var p = lo; p <= hi; p++) {
                    var pNum = p;
                    pg.appendChild(mkBtn(p, p === cur ? null : pNum, p === cur ? 'on' : ''));
                }
                if (hi < pages) { if (hi < pages - 1) pg.appendChild(mkEllipsis()); pg.appendChild(mkBtn(pages, pages, '')); }

                pg.appendChild(mkBtn('&rsaquo;', cur < pages ? cur + 1 : null, cur === pages ? 'off' : ''));
                pg.appendChild(mkBtn('&raquo;', cur < pages ? pages    : null, cur === pages ? 'off' : ''));
            };

            window.AppTable = AppTable;

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('table#tabel, table.datatable').forEach(function (t) {
                    new AppTable(t);
                });
            });
        })();

        // Datepicker
        $(document).ready(function () {
            if ($.fn.datepicker) {
                $('#tanggal_laporan').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayHighlight: true
                });
            }
        });

        // Excel export
        function exportToExcel() {
            var table = document.getElementById('tabel');
            var clonedTable = table.cloneNode(true);
            var rows = clonedTable.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                rows[i].deleteCell(-1);
            }
            var ws = XLSX.utils.table_to_sheet(clonedTable);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            var wbout = XLSX.write(wb, { type: 'binary', bookType: 'xlsx' });
            var blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "export.xlsx";
            link.click();
        }

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) { view[i] = s.charCodeAt(i) & 0xFF; }
            return buf;
        }
    </script>
</body>

</html>
