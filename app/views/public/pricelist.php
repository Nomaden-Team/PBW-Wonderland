<?php
$jumlah_wahana = 0;
?>
<!DOCTYPE html>
<html lang="id" id="htmlRoot">
<head>
    <title>Daftar Harga - Wonderland Samarinda</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script>(function(){ var t=localStorage.getItem('wl_theme')||'light'; document.documentElement.setAttribute('data-theme',t); })();</script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ---- Page-specific styles ---- */
        .pl-hero {
            background: linear-gradient(135deg, #DC2626 0%, #F97316 60%, #FBBF24 100%);
            padding: 80px 0 60px;
            color: #fff;
            text-align: center;
        }
        .pl-hero h1 { font-family: 'Baloo 2', sans-serif; font-size: 2.6rem; font-weight: 800; margin-bottom: 10px; }
        .pl-hero p  { font-size: 1.05rem; opacity: 0.9; }

        .pl-section { padding: 60px 0 80px; background: #F8F9FB; }

        .pl-category { margin-bottom: 32px; }

        .pl-cat-header {
            background: linear-gradient(135deg, #F97316 0%, #FBBF24 100%);
            border-radius: 14px 14px 0 0;
            padding: 16px 26px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pl-cat-header i   { color: #fff; font-size: 1.1rem; }
        .pl-cat-header span { font-size: 1rem; font-weight: 700; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; }

        .pl-cat-body {
            background: #fff;
            border-radius: 0 0 14px 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .pl-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 26px;
            border-bottom: 1px solid #F3F4F6;
            gap: 20px;
        }
        .pl-item:last-child { border-bottom: none; }

        .pl-item-left { flex: 1; }
        .pl-item-name {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 3px;
        }
        .pl-badge-active {
            font-size: 0.65rem;
            font-weight: 700;
            background: #D1FAE5;
            color: #065F46;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .pl-item-desc { font-size: 0.78rem; color: #9CA3AF; margin: 0; }

        .pl-prices {
            display: flex;
            gap: 28px;
            align-items: flex-end;
            flex-shrink: 0;
        }
        .pl-price-col { text-align: right; }
        .pl-price-col label { display: block; font-size: 0.7rem; color: #9CA3AF; margin-bottom: 2px; }
        .pl-price-normal { font-size: 0.85rem; font-weight: 600; color: #9CA3AF; text-decoration: line-through; }
        .pl-price-promo  { font-size: 1rem; font-weight: 800; color: #DC2626; }

        .pl-note {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            padding: 24px 28px;
            margin-top: 10px;
        }
        .pl-note h5 { font-weight: 700; color: #111827; margin-bottom: 12px; }
        .pl-note ul  { color: #6B7280; font-size: 0.88rem; padding-left: 20px; margin: 0; }
        .pl-note ul li { margin-bottom: 6px; }

        .pl-empty {
            text-align: center;
            padding: 60px 20px;
            color: #9CA3AF;
            font-size: 0.95rem;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .pl-empty i { font-size: 2.5rem; display: block; margin-bottom: 12px; }

        .pl-cta {
            text-align: center;
            padding: 50px 20px 0;
        }
        .pl-cta h3 { font-weight: 800; font-size: 1.5rem; margin-bottom: 8px; }
        .pl-cta p  { color: #6B7280; margin-bottom: 22px; }

        @media (max-width: 600px) {
            .pl-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .pl-prices { gap: 16px; }
        }

        /* Dark mode overrides khusus pricelist */
        [data-theme="dark"] .pl-section { background: #0f0c1e !important; }
        [data-theme="dark"] .pl-cat-body { background: #1e1b3a !important; border-color: #2d2a4a !important; }
        [data-theme="dark"] .pl-item { border-bottom-color: #2d2a4a !important; }
        [data-theme="dark"] .pl-item-name { color: #f1f5f9 !important; }
        [data-theme="dark"] .pl-item-desc { color: #64748b !important; }
        [data-theme="dark"] .pl-note { background: #1e1b3a !important; }
        [data-theme="dark"] .pl-note h5 { color: #f1f5f9 !important; }
        [data-theme="dark"] .pl-note ul { color: #94a3b8 !important; }
        [data-theme="dark"] .pl-empty { background: #1e1b3a !important; color: #64748b !important; }
        [data-theme="dark"] .pl-cta h3 { color: #f1f5f9 !important; }
        [data-theme="dark"] .pl-cta p { color: #94a3b8 !important; }
        [data-theme="dark"] .pl-badge-active { background: #064e3b; color: #6ee7b7; }
    </style>
    <link rel="stylesheet" href="assets/css/enhance.css">
</head>
<body class="landing-page">

<!-- Navbar (sama dengan home) -->
<nav class="navbar navbar-expand-lg custom-navbar landing-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand landing-brand" href="index.php">
            <span>Wonderland</span> <span>Samarinda</span>
        </a>
        <div class="d-flex align-items-center gap-2 ms-auto me-2">
            <button id="darkModeToggle" class="dark-mode-toggle" title="Toggle Dark Mode" aria-label="Toggle Dark Mode">
                <i class="bi bi-moon-fill" id="darkModeIcon"></i>
            </button>
        </div>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 landing-nav-links">
                <li class="nav-item"><a class="nav-link" href="index.php#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#attraction">Attractions</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#gallery">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#ulasan">Reviews</a></li>
                <li class="nav-item"><a class="nav-link active" href="index.php?page=pricelist">Harga Tiket</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#find-us">Location</a></li>
            </ul>
            <div class="d-flex align-items-center gap-3 ms-lg-4 mt-3 mt-lg-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <button class="btn-user-nav dropdown-toggle d-flex align-items-center gap-2 fw-bold px-3"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar-sm">
                                <?= strtoupper(substr($_SESSION['nama'], 0, 1)) ?>
                            </div>
                            <?= htmlspecialchars($_SESSION['nama']) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2">
                            <li><a class="dropdown-item py-2" href="<?= $_SESSION['role'] === 'admin' ? 'index.php?page=admin_dashboard' : 'index.php?page=user_dashboard' ?>">
                                <i class="bi bi-grid me-2 text-primary"></i> Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="#" onclick="konfirmasiLogout(event)">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="index.php?page=login" class="btn landing-login-btn">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Hero -->
<div class="pl-hero" data-aos="fade-down">
    <div class="container">
        <h1><i class="bi bi-ticket-perforated me-2"></i> Daftar Harga Tiket</h1>
        <p>Harga tiket masuk, wahana, dan layanan Wonderland Samarinda</p>
    </div>
</div>

<!-- Price List Section -->
<section class="pl-section">
    <div class="container">

        <?php if (empty($pricelist_grouped)): ?>
            <div class="pl-empty" data-aos="fade-up">
                <i class="bi bi-ticket-perforated"></i>
                Daftar harga belum tersedia.<br>Silakan hubungi kami untuk informasi harga terkini.
            </div>
        <?php else: ?>

        <?php
        $cat_icons = [
            'Tiket Masuk' => 'bi bi-ticket-perforated',
            'Wahana'      => 'bi bi-stars',
            'Parking'     => 'bi bi-car-front',
            'Lainnya'     => 'bi bi-grid',
        ];
        $delay = 0;
        foreach ($pricelist_grouped as $kategori => $items):
            $icon = $cat_icons[$kategori] ?? 'bi bi-tag';
            $delay += 100;
        ?>
        <div class="pl-category" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <div class="pl-cat-header">
                <i class="<?= $icon ?>"></i>
                <span><?= htmlspecialchars($kategori) ?></span>
            </div>
            <div class="pl-cat-body">
                <?php foreach ($items as $item): ?>
                <div class="pl-item">
                    <div class="pl-item-left">
                        <p class="pl-item-name">
                            <?= htmlspecialchars($item['nama']) ?>
                            <span class="pl-badge-active">Aktif</span>
                        </p>
                        <?php if (!empty($item['deskripsi'])): ?>
                            <p class="pl-item-desc"><?= htmlspecialchars($item['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="pl-prices">
                        <?php if ($item['harga_normal'] > 0 && $item['harga_normal'] !== $item['harga_promo']): ?>
                        <div class="pl-price-col">
                            <label>Normal</label>
                            <span class="pl-price-normal">Rp <?= number_format($item['harga_normal'], 0, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="pl-price-col">
                            <label>Harga</label>
                            <span class="pl-price-promo">
                                Rp <?= number_format($item['harga_promo'] ?: $item['harga_normal'], 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>


        <div class="pl-note" data-aos="fade-up">
            <h5><i class="bi bi-info-circle-fill text-warning me-2"></i> Catatan Penting</h5>
            <ul>
                <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
                <li>Anak di bawah 3 tahun <strong>gratis</strong> masuk (dengan syarat & ketentuan).</li>
                <li>Tiket yang sudah dibeli <strong>tidak dapat dikembalikan</strong>.</li>
                <li>Untuk grup 20+ orang, hubungi kami untuk informasi harga khusus grup.</li>
                <li>Harga wahana belum termasuk harga tiket masuk taman.</li>
            </ul>
        </div>


        <div class="pl-cta" data-aos="fade-up">
            <h3>Siap Berkunjung? 🎉</h3>
            <p>Pesan reservasi sekarang dan nikmati pengalaman tak terlupakan di Wonderland Samarinda!</p>
            <a href="index.php?page=user_reservasi" class="btn landing-btn-primary me-2">
                <i class="bi bi-calendar-check me-1"></i> Buat Reservasi
            </a>
            <a href="index.php#attraction" class="btn landing-btn-secondary">
                Lihat Wahana
            </a>
        </div>

    </div>
</section>

<!-- Footer ringkas -->
<footer class="footer landing-footer pt-4 pb-3">
    <div class="container text-center">
        <p class="mb-1" style="color:rgba(255,255,255,0.6); font-size:.85rem">
            © 2026 Wonderland Samarinda. All rights reserved.
        </p>
        <a href="index.php" style="color:rgba(255,255,255,0.5); font-size:.82rem">← Kembali ke Beranda</a>
    </div>
</footer>

<!-- Modal Logout -->
<div class="modal fade" id="modalLogout" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body text-center p-4">
                <i class="bi bi-box-arrow-right text-danger" style="font-size:2.5rem;"></i>
                <h6 class="fw-bold my-2">Konfirmasi Logout</h6>
                <p class="text-muted small mb-4">Yakin ingin keluar?</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary flex-fill rounded-3" data-bs-dismiss="modal">Batal</button>
                    <a href="index.php?page=logout" class="btn btn-danger flex-fill rounded-3 fw-bold">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });
function konfirmasiLogout(e) {
    e.preventDefault();
    new bootstrap.Modal(document.getElementById('modalLogout')).show();
}
(function() {
    function applyTheme(t) {
        document.documentElement.setAttribute('data-theme', t);
        var icon = document.getElementById('darkModeIcon');
        if (icon) icon.className = t === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    }
    applyTheme(localStorage.getItem('wl_theme') || 'light');
    var btn = document.getElementById('darkModeToggle');
    if (btn) btn.addEventListener('click', function() {
        var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        localStorage.setItem('wl_theme', next);
    });
})();
</script>
</body>
</html>
