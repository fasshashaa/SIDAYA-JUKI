<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDAYA - Dinas Sosial PPPA Kabupaten Cilacap</title>
<link rel="icon" type="image/png" href="{{ asset('img/Logo_sdy.png') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('img/Logo_sdy.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── NAVBAR ── */
        .nav-wrap {
            position: fixed; top: 0; left: 0; right: 0; z-index: 50;
            background: rgba(255,255,255,0.97);
            border-bottom: 1px solid #DCEAF0;
            backdrop-filter: blur(8px);
        }
        .nav-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 14px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-logo { display: flex; align-items: center; gap: 12px; }
        .nav-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: #0B2A4A;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .nav-icon svg { width: 22px; height: 22px; stroke: #5FD9E8; stroke-width: 2; fill: none; }
        .nav-name-1 { font-size: 11.5px; font-weight: 700; color: #0B2A4A; letter-spacing: 0.07em; margin: 0; }
        .nav-name-2 { font-size: 10px; color: #6B8AA0; letter-spacing: 0.04em; margin: 0; }
        .btn-masuk {
            background: #0E7C9E; color: #fff;
            border: none; border-radius: 50px;
            padding: 9px 22px; font-size: 13px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-masuk:hover { background: #0B6580; }

        /* ── HERO ── */
        .hero-section {
            background: #0A1F38;
            padding: 120px 32px 80px;
            position: relative; overflow: hidden;
        }
        .hero-deco-1 {
            position: absolute; top: -80px; right: 100px;
            width: 380px; height: 380px; border-radius: 50%;
            background: rgba(14,124,158,0.10); pointer-events: none;
        }
        .hero-deco-2 {
            position: absolute; bottom: -80px; left: 25%;
            width: 260px; height: 260px; border-radius: 50%;
            background: rgba(255,255,255,0.03); pointer-events: none;
        }
        .hero-deco-line {
            position: absolute; top: 0; right: 280px;
            width: 2px; height: 100%;
            background: rgba(14,124,158,0.35); pointer-events: none;
        }
        .hero-inner {
            max-width: 1280px; margin: 0 auto;
            display: grid; grid-template-columns: 1.1fr 0.9fr;
            gap: 48px; align-items: center; position: relative; z-index: 1;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px; padding: 5px 14px;
            font-size: 10.5px; color: #5FD9E8;
            letter-spacing: 0.08em; font-weight: 600;
            margin-bottom: 20px; text-transform: uppercase;
        }
        .hero-badge-dot {
            display: inline-block; width: 6px; height: 6px;
            border-radius: 50%; background: #5FD9E8;
        }
        .hero-title {
            font-size: 46px; font-weight: 800;
            line-height: 1.1; color: #fff;
            letter-spacing: -0.02em; margin: 0 0 6px;
        }
        .hero-title-accent { color: #2BC4D9; display: block; }
        .hero-sub {
            font-size: 14px; color: rgba(255,255,255,0.55);
            line-height: 1.75; margin: 20px 0 34px;
            max-width: 420px;
            border-left: 3px solid #0E7C9E; padding-left: 16px;
            border-radius: 0;
        }
        .hero-cta-wrap { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .btn-cta-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: #0E7C9E; color: #fff;
            border: none; border-radius: 12px;
            padding: 13px 26px; font-size: 14px; font-weight: 700;
            cursor: pointer; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-cta-primary:hover { background: #0B6580; }
       .btn-cta-ghost {
    display: inline-flex; 
    align-items: center; 
    gap: 8px;
    background: #0B2A4A; /* Abu-abu gelap */
    color: #ffffff;      /* Putih keabu-abuan agar kontras */
    border: 1px solid #4A5568; 
    border-radius: 12px;
    padding: 13px 22px; 
    font-size: 14px; 
    font-weight: 500;
    cursor: pointer; 
    text-decoration: none;
    transition: all 0.2s;
}

.btn-cta-ghost:hover {
    background: #293d63; /* Lebih terang sedikit saat di-hover */
    border-color: #718096;
    color: #FFFFFF;
}
        /* HERO VISUAL */
        .hero-visual-wrap {
            display: flex; justify-content: center; align-items: center;
        }
        .hero-orb-outer {
            width: 220px; height: 220px; border-radius: 50%;
            border: 2px solid rgba(14,124,158,0.55);
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }
        .hero-orb-mid {
            width: 165px; height: 165px; border-radius: 50%;
            border: 1px solid rgba(43,196,217,0.3);
            display: flex; align-items: center; justify-content: center;
            position: absolute;
        }
        .hero-orb-center {
            width: 100px; height: 100px; border-radius: 50%;
            background: rgba(14,124,158,0.2);
            border: 2px solid #0E7C9E;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            position: absolute;
        }
        .hero-orb-text { font-size: 22px; font-weight: 800; color: #5FD9E8; letter-spacing: -0.02em; }
        .hero-orb-sub { font-size: 8px; color: rgba(95,217,232,0.55); letter-spacing: 0.1em; margin-top: 2px; }
        .hero-pill {
            position: absolute;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 8px; padding: 5px 10px;
            font-size: 10.5px; color: rgba(255,255,255,0.75);
            font-weight: 500; white-space: nowrap;
            display: flex; align-items: center; gap: 5px;
        }
        .pill-dot { display: inline-block; width: 6px; height: 6px; border-radius: 50%; }
        .hp-1 { top: 16px; right: -24px; }
        .hp-2 { bottom: 28px; left: -36px; }
        .hp-3 { top: 50%; right: -56px; transform: translateY(-50%); }

        /* ── STATS BAR ── */
        .stats-bar {
            background: #EFF8FA;
            border-top: 1px solid #CDE6EC;
            border-bottom: 1px solid #CDE6EC;
        }
        .stats-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 22px 32px;
            display: flex; justify-content: space-around; align-items: center;
        }
        .stat-item { text-align: center; }
        .stat-num { font-size: 28px; font-weight: 800; color: #0E7C9E; margin: 0; line-height: 1.1; }
        .stat-lbl { font-size: 10.5px; color: #6B8AA0; letter-spacing: 0.05em; text-transform: uppercase; font-weight: 500; }
        .stat-divider { width: 1px; height: 40px; background: #C0DCE4; }

        /* ── SECTION COMMON ── */
        .section-wrap { padding: 64px 32px; }
        .section-inner { max-width: 1280px; margin: 0 auto; }
        .section-alt { background: #F4FAFB; }
        .accent-bar-o { width: 36px; height: 3px; background: #2BC4D9; border-radius: 2px; margin-bottom: 18px; }
        .accent-bar-g { width: 36px; height: 3px; background: #0B2A4A; border-radius: 2px; margin-bottom: 18px; }
        .section-tag {
            display: inline-block;
            background: #E3F3F7; color: #0B2A4A;
            font-size: 10.5px; font-weight: 700; letter-spacing: 0.07em;
            text-transform: uppercase; padding: 4px 12px; border-radius: 50px;
            margin-bottom: 12px;
        }
        .section-tag-o { background: #E0F6FA; color: #0E7C9E; }
        .section-title { font-size: 30px; font-weight: 800; color: #0A1F38; margin: 0 0 8px; letter-spacing: -0.02em; }
        .section-sub { font-size: 14px; color: #5A7A8C; margin: 0 0 36px; }

        /* ── PRODUK CARDS ── */
        .produk-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        @media (max-width: 900px) { .produk-grid { grid-template-columns: 1fr; } }
        .produk-card {
            background: #fff; border-radius: 16px;
            border: 1px solid #D9EBF0; overflow: hidden;
            cursor: pointer; transition: border-color 0.2s, transform 0.2s;
            text-decoration: none; display: block; color: inherit;
        }
        .produk-card:hover { border-color: #0E7C9E; transform: translateY(-4px); }
        .card-img {
            height: 140px;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px;
            background-size: cover; background-position: center;
        }
        .card-img-g { background-color: #E3F3F7; }
        .card-img-o { background-color: #DFF6FA; }
        .card-img-b { background-color: #E5EEFB; }
        .card-body { padding: 18px; }
        .card-cat { font-size: 10px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: #0E7C9E; margin-bottom: 6px; }
        .card-title { font-size: 15px; font-weight: 700; color: #0A1F38; margin: 0 0 6px; }
        .card-desc { font-size: 12.5px; color: #5A7A8C; line-height: 1.6; margin: 0 0 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-foot { display: flex; align-items: center; justify-content: space-between; }
        .card-loc { font-size: 11px; color: #8FA8B8; }
        .card-arrow {
            width: 28px; height: 28px; border-radius: 50%;
            background: #EFF8FA; border: 1px solid #CDE6EC;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: #0E7C9E; font-weight: 600;
        }
        .produk-empty {
            grid-column: 1 / -1;
            text-align: center; padding: 48px 20px;
            color: #8FA8B8; font-size: 13px;
            border: 1px dashed #CDE6EC; border-radius: 16px;
            background: #fff;
        }

        /* ── SEBARAN BANTUAN (CHART) ── */
        .chart-card {
            background: linear-gradient(180deg, #ffffff 0%, #FBFEFF 100%);
            border: 1px solid #E1EFF3; border-radius: 20px;
            padding: 32px 28px 24px;
            box-shadow: 0 1px 2px rgba(10,31,56,0.03), 0 12px 32px -16px rgba(14,124,158,0.18);
            position: relative; overflow: hidden;
        }
        .chart-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #0E7C9E, #5FD9E8, #8FB8E8);
        }
        .chart-head {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 14px; margin-bottom: 22px;
        }
        .chart-legend { display: flex; gap: 18px; flex-wrap: wrap; }
        .chart-legend-item {
            display: flex; align-items: center; gap: 7px;
            font-size: 12px; font-weight: 600; color: #3E5A6C;
        }
        .chart-legend-swatch {
            width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0;
        }
        .chart-total-badge {
            display: flex; flex-direction: column; align-items: flex-end;
        }
        .chart-total-num { font-size: 22px; font-weight: 800; color: #0A1F38; line-height: 1.1; }
        .chart-total-lbl { font-size: 10px; color: #8FA8B8; letter-spacing: 0.06em; text-transform: uppercase; }
        .chart-canvas-wrap { position: relative; }

        /* ── VISI MISI ── */
        .vm-grid {
            display: grid; grid-template-columns: 0.85fr 1.15fr; gap: 28px; align-items: stretch;
        }
        @media (max-width: 900px) { .vm-grid { grid-template-columns: 1fr; } }
        .vm-visi-card {
            background: linear-gradient(155deg, #0A1F38 0%, #0B2A4A 55%, #0E4A63 100%);
            border-radius: 20px; padding: 36px 32px;
            position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: center;
        }
        .vm-visi-card::after {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(95,217,232,0.16) 0%, rgba(95,217,232,0) 70%);
        }
        .vm-visi-quote {
            font-size: 34px; color: rgba(95,217,232,0.5); font-weight: 800;
            line-height: 0.5; margin-bottom: 14px;
        }
        .vm-visi-label {
            display: inline-block; font-size: 10.5px; font-weight: 700; letter-spacing: 0.09em;
            text-transform: uppercase; color: #5FD9E8; margin-bottom: 14px;
        }
        .vm-visi-text {
            font-size: 18px; line-height: 1.65; color: #EAF4F7; font-weight: 500;
            font-style: italic; position: relative; z-index: 1;
        }
        .vm-misi-list { display: flex; flex-direction: column; gap: 14px; }
        .vm-misi-item {
            background: #fff; border: 1px solid #D9EBF0; border-radius: 14px;
            padding: 18px 20px; display: flex; gap: 16px; align-items: flex-start;
            transition: border-color 0.2s, transform 0.2s;
        }
        .vm-misi-item:hover { border-color: #0E7C9E; transform: translateX(2px); }
        .vm-misi-num {
            flex-shrink: 0; width: 34px; height: 34px; border-radius: 10px;
            background: #E3F3F7; color: #0E7C9E;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 800;
        }
        .vm-misi-title { font-size: 14px; font-weight: 700; color: #0A1F38; margin: 0 0 4px; }
        .vm-misi-desc { font-size: 12.5px; color: #5A7A8C; line-height: 1.6; margin: 0; }

        /* ── FOOTER ── */
        .footer-wrap {
            background: #061629;
            border-top: 1px solid rgba(14,124,158,0.4);
        }
        .footer-inner {
            max-width: 1280px; margin: 0 auto;
            padding: 28px 32px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .footer-left { display: flex; align-items: center; gap: 10px; }
        .footer-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(14,124,158,0.4);
            display: flex; align-items: center; justify-content: center;
        }
        .footer-icon svg { width: 16px; height: 16px; stroke: #5FD9E8; stroke-width: 2; fill: none; }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,0.3); }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a { font-size: 12px; color: rgba(255,255,255,0.35); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: #5FD9E8; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .hero-inner { grid-template-columns: 1fr; }
            .hero-visual-wrap { display: none; }
            .hero-title { font-size: 32px; }
            .produk-grid { grid-template-columns: 1fr; }
            .stats-inner { gap: 16px; }
            .stat-num { font-size: 22px; }
        }
    </style>
</head>
<body style="background:#F4FAFB; margin:0;">

    @php
        use Illuminate\Support\Facades\DB;
        use App\Models\Uep;
        use App\Models\Kube;
        use App\Models\PenerimaManfaat;
        use App\Models\ProdukUmkm;
        use App\Models\Activity;

        // ===== STATS BAR (data asli) =====
        $totalUepAktif = Uep::where('status_verifikasi', 'disetujui')
            ->where('status_usaha', 'Aktif')
            ->count();

        $totalUepTerverifikasi = Uep::where('status_verifikasi', 'disetujui')->count();

        // Jumlah kecamatan unik dari tabel wilayah_desas (data wilayah asli)
        $totalKecamatan = DB::table('wilayah_desas')->distinct()->count('kecamatan_nama');
        if ($totalKecamatan === 0) {
            // fallback kalau tabel wilayah_desas belum terisi
            $totalKecamatan = Uep::distinct()->count('kecamatan_usaha');
        }

        $totalPenerimaManfaat = PenerimaManfaat::count();

        $tingkatAktif = $totalUepTerverifikasi > 0
            ? round(($totalUepAktif / $totalUepTerverifikasi) * 100)
            : 0;

        // ===== SEBARAN BANTUAN (data asli untuk grafik) =====
        $totalPM = $totalPenerimaManfaat;
        $totalUEP = Uep::where('status_verifikasi', 'disetujui')->count();
        $totalKUBE = Kube::where('status_verifikasi', 'disetujui')->count();

        // ===== PRODUK UNGGULAN (data asli, yang ditampilkan & masih ada stok) =====
        $produkUnggulan = ProdukUmkm::with(['uep', 'kube'])
            ->where('status_publikasi', 'Ditampilkan')
            ->where('stok', '>', 0)
            ->latest()
            ->take(3)
            ->get();

        $cardImgClasses = ['card-img-g', 'card-img-o', 'card-img-b'];
    @endphp

    <!-- Navbar -->
    <nav class="nav-wrap">
        <div class="nav-inner">
            <div class="nav-logo">
           
                 <img src="{{ asset('img/Logo_sdy.png') }}" alt="Logo Dinsos" style="width:42px;height:42px;object-fit:contain;"> 
                <div>
                    <p class="nav-name-1">Dinas Sosial PPPA</p>
                    <p class="nav-name-2">Kabupaten Cilacap</p>
                </div>
            </div>
            <a href="{{ route('login') }}" class="btn-cta-ghost">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
    <polyline points="10 17 15 12 10 7"/>
    <line x1="15" y1="12" x2="3" y2="12"/>
</svg>     Masuk Sistem
                    </a>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero-section">
        <div class="hero-deco-1"></div>
        <div class="hero-deco-2"></div>
        <div class="hero-deco-line"></div>
        <div class="hero-inner">
            <!-- Kiri -->
            <div>
                {{-- <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Platform Terintegrasi
                </div> --}}
                <h1 class="hero-title">
                    SIDAYA
                    <span class="hero-title-accent">Inovasi Usaha Ekonomi Produktif</span>
                </h1>
                <p class="hero-sub">
                    Platform terintegrasi untuk memonitor perkembangan usaha ekonomi produktif (UEP), transparansi laporan kinerja kegiatan, dan pusat pasar digital produk unggulan binaan dinas.
                </p>
                <div class="hero-cta-wrap">
                    <a href="#produk" class="btn-cta-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Jelajahi Produk UMKM
                    </a>
                    {{-- <a href="{{ route('login') }}" class="btn-cta-ghost">
                        <svg width="16" height="16" viewBox="0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        Masuk Sistem
                    </a> --}}
                </div>
            </div>

            <!-- Kanan — Orb Visual -->
            <div class="hero-visual-wrap">
                <div class="hero-orb-outer">
                    <div class="hero-orb-mid"></div>
                    <div class="hero-orb-center">
                       
                    </div>
                    <img src="{{ asset('img/Logo_sdy.png') }}" style="width:80px;height:80px;object-fit:contain;position:absolute;"> 
                    <div class="hero-pill hp-1">
                        <span class="pill-dot" style="background:#5FD9E8"></span> UEP Aktif
                    </div>
                    <div class="hero-pill hp-2">
                        <span class="pill-dot" style="background:#2BC4D9"></span> Produk Binaan
                    </div>
                    <div class="hero-pill hp-3">
                        <span class="pill-dot" style="background:#8FB8E8"></span> Monitoring
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Stats Bar (data asli) -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <p class="stat-num">{{ $totalUepAktif }}</p>
                <p class="stat-lbl">UEP Aktif</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">{{ $totalKecamatan }}</p>
                <p class="stat-lbl">Kecamatan</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">{{ $totalPenerimaManfaat >= 1000 ? number_format($totalPenerimaManfaat / 1000, 1) . 'K' : $totalPenerimaManfaat }}</p>
                <p class="stat-lbl">Penerima Manfaat</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">{{ $tingkatAktif }}%</p>
                <p class="stat-lbl">Tingkat Aktif</p>
            </div>
        </div>
    </div>

    <!-- Visi & Misi Section -->
    <section class="section-wrap">
        <div class="section-inner">
            <div class="accent-bar-o"></div>
            <span class="section-tag">Arah Kebijakan</span>
            <h2 class="section-title">Visi &amp; Misi</h2>
            <p class="section-sub">Landasan gerak SIDAYA dalam mendukung program pemberdayaan masyarakat Dinas Sosial PPPA Kabupaten Cilacap.</p>

            <div class="vm-grid">
                <div class="vm-visi-card">
                    <span class="vm-visi-quote">&ldquo;</span>
                    <span class="vm-visi-label">Visi</span>
                    <p class="vm-visi-text">Menjadi platform digital yang inovatif dalam mengintegrasikan data pemberdayaan masyarakat guna menciptakan tata kelola bantuan yang tepat sasaran dan berkelanjutan.</p>
                </div>

                <div class="vm-misi-list">
                    <div class="vm-misi-item">
                        <div class="vm-misi-num">01</div>
                        <div>
                            <p class="vm-misi-title">Akurasi Data</p>
                            <p class="vm-misi-desc">Membangun database terpadu untuk memetakan potensi penerima manfaat dan profil usaha secara presisi dan terorganisir.</p>
                        </div>
                    </div>
                    <div class="vm-misi-item">
                        <div class="vm-misi-num">02</div>
                        <div>
                            <p class="vm-misi-title">Efisiensi Manajemen</p>
                            <p class="vm-misi-desc">Mengoptimalkan alur kerja pendataan UEP dan KUBE untuk mempermudah pemantauan serta koordinasi bagi pengelola program.</p>
                        </div>
                    </div>
                    <div class="vm-misi-item">
                        <div class="vm-misi-num">03</div>
                        <div>
                            <p class="vm-misi-title">Pemberdayaan Berkelanjutan</p>
                            <p class="vm-misi-desc">Mendukung pengembangan kapasitas pelaku UMKM melalui sistem pendataan yang memfasilitasi pendampingan dan legalitas usaha.</p>
                        </div>
                    </div>
                    <div class="vm-misi-item">
                        <div class="vm-misi-num">04</div>
                        <div>
                            <p class="vm-misi-title">Integritas Sistem</p>
                            <p class="vm-misi-desc">Mengedepankan kemudahan akses informasi bagi setiap pemangku kepentingan dalam mendukung penguatan ekonomi lokal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sebaran Bantuan Section (grafik) -->
    <section class="section-wrap section-alt">
        <div class="section-inner">
            <div class="accent-bar-g"></div>
            <span class="section-tag section-tag-o">Transparansi</span>
            <h2 class="section-title">Sebaran Bantuan</h2>
            <p class="section-sub">Distribusi bantuan Penerima Manfaat, UEP, dan KUBE yang dikelola Dinas Sosial PPPA Kabupaten Cilacap.</p>

            <div class="chart-card">
                <div class="chart-head">
                    <div class="chart-legend">
                        <span class="chart-legend-item"><span class="chart-legend-swatch" style="background:#0E7C9E"></span> Penerima Manfaat</span>
                        <span class="chart-legend-item"><span class="chart-legend-swatch" style="background:#2BC4D9"></span> UEP</span>
                        <span class="chart-legend-item"><span class="chart-legend-swatch" style="background:#8FB8E8"></span> KUBE</span>
                    </div>
                    <div class="chart-total-badge">
                        <span class="chart-total-num">{{ number_format($totalPM + $totalUEP + $totalKUBE) }}</span>
                        <span class="chart-total-lbl">Total Terdata</span>
                    </div>
                </div>
                <div class="chart-canvas-wrap">
                    <canvas id="sebaranBantuanChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Section (data asli) -->
    <section id="produk" class="section-wrap">
        <div class="section-inner">
            <div class="accent-bar-o"></div>
            <span class="section-tag">Produk Unggulan</span>
            <h2 class="section-title">Pasar Digital UMKM Cilacap</h2>
            <p class="section-sub">Temukan produk berkualitas dari pelaku usaha binaan Dinas Sosial PPPA.</p>

            <div class="produk-grid">
                @forelse($produkUnggulan as $index => $produk)
                    @php
                        $pemilikNama = $produk->uep->nama_usaha ?? ($produk->kube->nama_kelompok_kube ?? null);
                        $lokasi = $produk->uep->kecamatan_usaha ?? ($produk->kube->kecamatan_kube ?? null);
                        $imgClass = $cardImgClasses[$index % count($cardImgClasses)];
                    @endphp
                    <a href="{{ route('login') }}" class="produk-card">
                        <div class="card-img {{ $imgClass }}"
                             @if($produk->foto_produk) style="background-image:url('{{ asset('storage/' . $produk->foto_produk) }}'); font-size:0;" @endif>
                            @if(!$produk->foto_produk) 🛍️ @endif
                        </div>
                        <div class="card-body">
                            <div class="card-cat">{{ $produk->kategori }}</div>
                            <h3 class="card-title">{{ $produk->nama_produk }}</h3>
                            <p class="card-desc">{{ $produk->deskripsi_produk ?? ('Produk unggulan binaan ' . ($pemilikNama ?? 'UMKM Cilacap') . '.') }}</p>
                            <div class="card-foot">
                                <span class="card-loc">📍 {{ $lokasi ?? 'Cilacap' }}</span>
                                <div class="card-arrow">→</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="produk-empty">
                        Belum ada produk unggulan yang ditampilkan saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-wrap">
        <div class="footer-inner">
            <div class="footer-left">
                
                <span class="footer-copy">© 2026 SIDAYA — Dinas Sosial PPPA Kabupaten Cilacap</span>
            </div>
            {{-- <div class="footer-links">
                <a href="#">Tentang</a>
                <a href="#">Kebijakan</a>
                <a href="#">Kontak</a>
            </div> --}}
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sebaranCanvas = document.getElementById('sebaranBantuanChart');
            if (sebaranCanvas) {
                const ctx = sebaranCanvas.getContext('2d');

                const gPM = ctx.createLinearGradient(0, 0, 400, 0);
                gPM.addColorStop(0, '#0B5A75');
                gPM.addColorStop(1, '#0E7C9E');

                const gUEP = ctx.createLinearGradient(0, 0, 400, 0);
                gUEP.addColorStop(0, '#0E7C9E');
                gUEP.addColorStop(1, '#2BC4D9');

                const gKUBE = ctx.createLinearGradient(0, 0, 400, 0);
                gKUBE.addColorStop(0, '#5FA8E0');
                gKUBE.addColorStop(1, '#8FB8E8');

                // Plugin: nilai di ujung batang
                const valueLabelPlugin = {
                    id: 'valueLabelPlugin',
                    afterDatasetsDraw(chart) {
                        const { ctx, data } = chart;
                        const meta = chart.getDatasetMeta(0);
                        ctx.save();
                        ctx.font = '700 12px "Plus Jakarta Sans", sans-serif';
                        ctx.fillStyle = '#0A1F38';
                        ctx.textBaseline = 'middle';
                        meta.data.forEach((bar, i) => {
                            const val = data.datasets[0].data[i];
                            ctx.textAlign = 'left';
                            ctx.fillText(val.toLocaleString('id-ID'), bar.x + 10, bar.y);
                        });
                        ctx.restore();
                    }
                };

                new Chart(sebaranCanvas, {
                    type: 'bar',
                    data: {
                        labels: ['Penerima Manfaat', 'UEP', 'KUBE'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [{{ $totalPM }}, {{ $totalUEP }}, {{ $totalKUBE }}],
                            backgroundColor: [gPM, gUEP, gKUBE],
                            borderRadius: 10,
                            borderSkipped: false,
                            barThickness: 28,
                            categoryPercentage: 0.6,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { right: 46 } },
                        animation: { duration: 900, easing: 'easeOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0A1F38',
                                titleFont: { family: "'Plus Jakarta Sans', sans-serif", weight: '700', size: 12 },
                                bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: (item) => ' ' + item.parsed.x.toLocaleString('id-ID') + ' data'
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: 'rgba(148,163,184,0.14)', drawBorder: false, borderDash: [4, 4] },
                                ticks: { color: '#8FA8B8', font: { size: 11 } }
                            },
                            y: {
                                grid: { display: false, drawBorder: false },
                                ticks: { color: '#3E5A6C', font: { size: 12.5, weight: '600' } }
                            }
                        }
                    },
                    plugins: [valueLabelPlugin]
                });
            }
        });
    </script>

</body>
</html>