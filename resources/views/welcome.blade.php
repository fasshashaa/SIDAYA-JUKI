<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDAYA - Dinas Sosial PPPA Kabupaten Cilacap</title>
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
        }
        .produk-card:hover { border-color: #0E7C9E; transform: translateY(-4px); }
        .card-img {
            height: 140px;
            display: flex; align-items: center; justify-content: center;
            font-size: 36px;
        }
        .card-img-g { background: #E3F3F7; }
        .card-img-o { background: #DFF6FA; }
        .card-img-b { background: #E5EEFB; }
        .card-body { padding: 18px; }
        .card-cat { font-size: 10px; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: #0E7C9E; margin-bottom: 6px; }
        .card-title { font-size: 15px; font-weight: 700; color: #0A1F38; margin: 0 0 6px; }
        .card-desc { font-size: 12.5px; color: #5A7A8C; line-height: 1.6; margin: 0 0 14px; }
        .card-foot { display: flex; align-items: center; justify-content: space-between; }
        .card-loc { font-size: 11px; color: #8FA8B8; }
        .card-arrow {
            width: 28px; height: 28px; border-radius: 50%;
            background: #EFF8FA; border: 1px solid #CDE6EC;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: #0E7C9E; font-weight: 600;
        }

        /* ── LAPORAN CARDS ── */
        .laporan-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        @media (max-width: 700px) { .laporan-grid { grid-template-columns: 1fr; } }
        .laporan-card {
            background: #fff; border-radius: 14px;
            border: 1px solid #D9EBF0;
            padding: 18px; display: flex; gap: 14px; align-items: flex-start;
            transition: border-color 0.2s;
        }
        .laporan-card:hover { border-color: #0E7C9E; }
        .lap-date {
            min-width: 52px; height: 52px; border-radius: 10px;
            background: #0A1F38; flex-shrink: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
        }
        .lap-day { font-size: 18px; font-weight: 800; color: #5FD9E8; line-height: 1; }
        .lap-mon { font-size: 9px; color: rgba(95,217,232,0.5); letter-spacing: 0.06em; text-transform: uppercase; }
        .lap-title { font-size: 14px; font-weight: 700; color: #0A1F38; margin: 0 0 4px; }
        .lap-desc { font-size: 12.5px; color: #5A7A8C; margin: 0 0 10px; line-height: 1.5; }
        .lap-tag {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 50px;
        }
        .tag-g { background: #E3F3F7; color: #0B2A4A; }
        .tag-o { background: #DFF6FA; color: #0E7C9E; }
        .tag-b { background: #E5EEFB; color: #1A4DB8; }
        .tag-p { background: #EDEAFB; color: #5A2AB8; }
        .tag-dot { display: inline-block; width: 5px; height: 5px; border-radius: 50%; }

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

    <!-- Navbar -->
    <nav class="nav-wrap">
        <div class="nav-inner">
            <div class="nav-logo">
           
                 <img src="{{ asset('img/dinsos.png') }}" alt="Logo Dinsos" style="width:42px;height:42px;object-fit:contain;"> 
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

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <p class="stat-num">248</p>
                <p class="stat-lbl">UEP Aktif</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">32</p>
                <p class="stat-lbl">Kecamatan</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">1.2K</p>
                <p class="stat-lbl">Penerima Manfaat</p>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <p class="stat-num">96%</p>
                <p class="stat-lbl">Tingkat Aktif</p>
            </div>
        </div>
    </div>

    <!-- Produk Section -->
    <section id="produk" class="section-wrap">
        <div class="section-inner">
            <div class="accent-bar-o"></div>
            <span class="section-tag">Produk Unggulan</span>
            <h2 class="section-title">Pasar Digital UMKM Cilacap</h2>
            <p class="section-sub">Temukan produk berkualitas dari pelaku usaha binaan Dinas Sosial PPPA.</p>

            <div class="produk-grid">
                <!-- Card 1 -->
                <div class="produk-card">
                    <div class="card-img card-img-g">🌿</div>
                    <div class="card-body">
                        <div class="card-cat">Pangan Olahan</div>
                        <h3 class="card-title">Keripik Tempe Aneka Rasa</h3>
                        <p class="card-desc">Produk unggulan hasil binaan UEP dari Kecamatan Adipala dengan varian rasa pilihan.</p>
                        <div class="card-foot">
                            <span class="card-loc">📍 Adipala</span>
                            <div class="card-arrow">→</div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="produk-card">
                    <div class="card-img card-img-o">🎋</div>
                    <div class="card-body">
                        <div class="card-cat">Kerajinan Tangan</div>
                        <h3 class="card-title">Anyaman Bambu Kreatif</h3>
                        <p class="card-desc">Kerajinan tangan unik berkualitas ekspor dari pengrajin binaan Kecamatan Majenang.</p>
                        <div class="card-foot">
                            <span class="card-loc">📍 Majenang</span>
                            <div class="card-arrow">→</div>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="produk-card">
                    <div class="card-img card-img-b">🌶️</div>
                    <div class="card-body">
                        <div class="card-cat">Bumbu & Rempah</div>
                        <h3 class="card-title">Sambal Terasi Instan</h3>
                        <p class="card-desc">Sambal khas Cilacap cita rasa tradisional asli, higienis dan tahan lama.</p>
                        <div class="card-foot">
                            <span class="card-loc">📍 Cilacap Kota</span>
                            <div class="card-arrow">→</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Laporan Section -->
    <section class="section-wrap section-alt">
        <div class="section-inner">
            <div class="accent-bar-g"></div>
            <span class="section-tag section-tag-o">Transparansi</span>
            <h2 class="section-title">Laporan Kegiatan Terbaru</h2>
            <p class="section-sub">Rekam jejak monitoring dan evaluasi program pemberdayaan ekonomi.</p>

            <div class="laporan-grid">
                <!-- Laporan 1 -->
                <div class="laporan-card">
                    <div class="lap-date">
                        <span class="lap-day">12</span>
                        <span class="lap-mon">Jun</span>
                    </div>
                    <div>
                        <h4 class="lap-title">Monitoring UEP di Cilacap Tengah</h4>
                        <p class="lap-desc">Evaluasi perkembangan usaha rintisan binaan bulan Juni di wilayah Cilacap Tengah.</p>
                        <span class="lap-tag tag-g">
                            <span class="tag-dot" style="background:#0B2A4A"></span> Monitoring
                        </span>
                    </div>
                </div>
                <!-- Laporan 2 -->
                <div class="laporan-card">
                    <div class="lap-date">
                        <span class="lap-day">05</span>
                        <span class="lap-mon">Jun</span>
                    </div>
                    <div>
                        <h4 class="lap-title">Pelatihan Digital Marketing</h4>
                        <p class="lap-desc">Workshop peningkatan kapasitas UMKM di Kecamatan Kesugihan, 40 peserta.</p>
                        <span class="lap-tag tag-o">
                            <span class="tag-dot" style="background:#0E7C9E"></span> Pelatihan
                        </span>
                    </div>
                </div>
                <!-- Laporan 3 -->
                <div class="laporan-card">
                    <div class="lap-date">
                        <span class="lap-day">28</span>
                        <span class="lap-mon">Mei</span>
                    </div>
                    <div>
                        <h4 class="lap-title">Distribusi Bantuan Modal UEP</h4>
                        <p class="lap-desc">Penyaluran bantuan modal usaha kepada 24 penerima manfaat di Jeruklegi.</p>
                        <span class="lap-tag tag-b">
                            <span class="tag-dot" style="background:#2060C8"></span> Distribusi
                        </span>
                    </div>
                </div>
                <!-- Laporan 4 -->
                <div class="laporan-card">
                    <div class="lap-date">
                        <span class="lap-day">20</span>
                        <span class="lap-mon">Mei</span>
                    </div>
                    <div>
                        <h4 class="lap-title">Evaluasi Triwulan II Program UEP</h4>
                        <p class="lap-desc">Rapat evaluasi capaian kinerja triwulan II bersama seluruh pendamping lapangan.</p>
                        <span class="lap-tag tag-p">
                            <span class="tag-dot" style="background:#6A30C8"></span> Evaluasi
                        </span>
                    </div>
                </div>
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

</body>
</html>