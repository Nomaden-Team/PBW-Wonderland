<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){try{var t=localStorage.getItem('wl_theme')||'light';document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
    <title>Dashboard Admin - Wonderland</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/enhance.css">
</head>
<body class="adm-body">

<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="adm-wrapper">
    <?php include __DIR__ . '/partials/topbar.php'; ?>

    <main class="adm-main">
        <div class="adm-page-header">
            <div>
                <h1 class="adm-page-title">Dashboard</h1>
                <p class="adm-page-sub">Selamat datang di admin panel Wonderland Samarinda</p>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="adm-stats-grid">
            <div class="adm-stat-card">
                <div class="adm-stat-top">
                    <div class="adm-stat-icon" style="background:#EF4444"><i class="far fa-calendar-alt"></i></div>
                    <span class="adm-stat-badge">+12%</span>
                </div>
                <p class="adm-stat-label">Total Reservasi</p>
                <p class="adm-stat-value"><?= number_format($total_reservasi) ?></p>
            </div>
            <div class="adm-stat-card">
                <div class="adm-stat-top">
                    <div class="adm-stat-icon" style="background:#10B981"><i class="fas fa-ticket-alt"></i></div>
                    <span class="adm-stat-badge">+1</span>
                </div>
                <p class="adm-stat-label">Wahana Aktif</p>
                <p class="adm-stat-value"><?= $wahana_aktif ?></p>
            </div>
            <div class="adm-stat-card">
                <div class="adm-stat-top">
                    <div class="adm-stat-icon" style="background:#F59E0B"><i class="fas fa-users"></i></div>
                    <span class="adm-stat-badge">+8%</span>
                </div>
                <p class="adm-stat-label">Pengunjung Hari Ini</p>
                <p class="adm-stat-value"><?= number_format($pengunjung_hari) ?></p>
            </div>
            <div class="adm-stat-card">
                <div class="adm-stat-top">
                    <div class="adm-stat-icon" style="background:#8B5CF6"><i class="fas fa-dollar-sign"></i></div>
                    <span class="adm-stat-badge">+15%</span>
                </div>
                <p class="adm-stat-label">Revenue Bulan Ini</p>
                <p class="adm-stat-value">Rp <?= $revenue >= 1000000 ? round($revenue/1000000).'M' : number_format($revenue) ?></p>
            </div>
        </div>


        <div class="adm-dash-grid">

            <div class="adm-card">
                <div class="adm-card-header">
                    <h3 class="adm-card-title">Reservasi Terbaru</h3>
                    <i class="fas fa-chart-line adm-card-icon-red"></i>
                </div>
                <?php if (empty($res_terbaru)): ?>
                    <p class="adm-empty">Belum ada reservasi</p>
                <?php else: ?>
                    <?php foreach ($res_terbaru as $r): ?>
                    <div class="adm-reservasi-item">
                        <div class="adm-res-info">
                            <p class="adm-res-name"><?= htmlspecialchars($r['nama_kegiatan'] ?? '') ?></p>
                            <p class="adm-res-sub"><?= htmlspecialchars($r['jenis_kegiatan'] ?? '') ?> &bull; <?= $r['tanggal'] ?? '' ?></p>
                        </div>
                        <span class="adm-badge adm-badge-<?= strtolower($r['status']) ?>"><?= ucfirst($r['status']) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


            <div class="adm-card">
                <div class="adm-card-header">
                    <h3 class="adm-card-title">Wahana Terpopuler</h3>
                    <i class="fas fa-arrow-trend-up adm-card-icon-green"></i>
                </div>
                <?php foreach ($wahana_populer as $i => $w): ?>
                <div class="adm-wahana-item">
                    <div class="adm-wahana-rank"><?= $i+1 ?></div>
                    <div class="adm-wahana-info">
                        <p class="adm-wahana-name"><?= htmlspecialchars($w['nama']) ?></p>
                        <p class="adm-wahana-pengunjung"><i class="fas fa-users" style="font-size:.7rem"></i> <?= htmlspecialchars($w['kapasitas'] ?? '-') ?></p>
                    </div>
                    <span class="adm-wahana-revenue">Rp <?= $w['harga'] >= 1000000 ? round($w['harga']/1000000).'M' : number_format($w['harga']) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>


        <div class="adm-quick-actions">
            <p class="adm-qa-title">Quick Actions</p>
            <div class="adm-qa-grid">
                <a href="index.php?page=admin_reservasi&modal=tambah" class="adm-qa-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>Tambah Reservasi</span>
                </a>
                <a href="index.php?page=admin_wahana&modal=tambah" class="adm-qa-item">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tambah Wahana</span>
                </a>
                <a href="index.php?page=admin_ulasan" class="adm-qa-item">
                    <i class="far fa-star"></i>
                    <span>Lihat Ulasan</span>
                </a>
            </div>
        </div>
    </main>
</div>

<button class="adm-help-btn">?</button>
<script src="assets/js/enhance.js"></script>
</body>
</html>
