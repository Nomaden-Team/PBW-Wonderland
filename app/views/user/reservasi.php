<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){try{var t=localStorage.getItem('wl_theme')||'light';document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
    <title>Reservasi Saya - Wonderland Samarinda</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/user-dashboard.css">

    <link rel="stylesheet" href="assets/css/enhance.css">
</head>
<body class="ud-body">

<?php $activePage = 'reservasi'; require __DIR__ . '/partials/sidebar.php'; ?>

<main class="ud-main">
    <div class="ud-topbar">
        <button type="button" class="ud-mobile-toggle" aria-label="Buka menu">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="ud-topbar-left">
            <div class="ud-page-icon" style="background: linear-gradient(135deg, #ff6b6b, #f5a623);">
                <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <h1 class="ud-page-title">Reservasi Saya</h1>
                <p class="ud-page-sub">Kelola dan lihat semua reservasi kunjungan Anda</p>
            </div>
        </div>
        <button type="button" class="wl-theme-toggle wl-theme-toggle--user" aria-label="Aktifkan mode gelap" aria-pressed="false">
            <span class="wl-theme-toggle-icon" aria-hidden="true">☾</span>
            <span class="wl-theme-toggle-label">Dark</span>
        </button>
        <button class="ud-btn-red" onclick="openReservasiModal()">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Reservasi
        </button>
        <div class="ud-topbar-line" ></div>
    </div>

    <?php if ((($_GET['status'] ?? '') === 'success') && !empty($_GET['kode'])): ?>
    <div class="ud-alert ud-alert-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
        Reservasi berhasil! Kode booking Anda: <strong><?= htmlspecialchars($_GET['kode']) ?></strong>
        &mdash; Tunjukkan kode ini saat datang ke Wonderland Samarinda.
    </div>
    <?php endif; ?>

    <?php
    $reservasis = $reservasis ?? [];
    $totalKonfirmasi = count(array_filter($reservasis, fn($r) => ($r['status'] ?? '') === 'terjadwal'));
    $totalMenunggu   = count(array_filter($reservasis, fn($r) => ($r['status'] ?? '') === 'pending'));
    $totalSelesai    = count(array_filter($reservasis, fn($r) => ($r['status'] ?? '') === 'selesai'));
    $totalAll        = count($reservasis);
    ?>
    <div class="ud-stats-row ud-stats-4">
        <div class="ud-stat-card ud-stat-border-green">
            <div class="ud-stat-info"><div class="ud-stat-label">Dikonfirmasi</div><div class="ud-stat-num"><?= $totalKonfirmasi ?></div></div>
            <div class="ud-stat-icon" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); color:#059669;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9,11 12,14 22,4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg></div>
        </div>
        <div class="ud-stat-card ud-stat-border-yellow">
            <div class="ud-stat-info"><div class="ud-stat-label">Menunggu</div><div class="ud-stat-num"><?= $totalMenunggu ?></div></div>
            <div class="ud-stat-icon" style="background:linear-gradient(135deg,#fffbf0,#fef0cc); color:#d4881a;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg></div>
        </div>
        <div class="ud-stat-card ud-stat-border-blue">
            <div class="ud-stat-info"><div class="ud-stat-label">Selesai</div><div class="ud-stat-num"><?= $totalSelesai ?></div></div>
            <div class="ud-stat-icon" style="background:linear-gradient(135deg,#eff6ff,#dbeafe); color:#2563eb;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg></div>
        </div>
        <div class="ud-stat-card ud-stat-border-red">
            <div class="ud-stat-info"><div class="ud-stat-label">Total</div><div class="ud-stat-num"><?= $totalAll ?></div></div>
            <div class="ud-stat-icon" style="background:linear-gradient(135deg,#fff0f0,#ffd6d6); color:#e84545;"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        </div>
    </div>

    <?php if (!empty($reservasis)): ?>
        <?php foreach ($reservasis as $r):
            $st = $r['status'] ?? 'terjadwal';
            $borderMap = ['terjadwal'=>'#26c6a6','selesai'=>'#3b82f6','dibatalkan'=>'#ff6b6b','pending'=>'#f5a623'];
            $stLabel = ['terjadwal'=>'Dikonfirmasi','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan','pending'=>'Menunggu'];
            $stClass = ['terjadwal'=>'confirmed','selesai'=>'completed','dibatalkan'=>'cancelled','pending'=>'pending'];
        ?>
        <div class="ud-card ud-reservasi-card" style="border-left:4px solid <?= $borderMap[$st] ?? '#e5e7eb' ?>;">
            <div class="ud-reservasi-card-top">
                <div>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                        <span class="ud-reservasi-name"><?= htmlspecialchars($r['nama_kegiatan']) ?></span>
                        <span class="ud-badge-status ud-badge-<?= $stClass[$st] ?? 'confirmed' ?>"><?= $stLabel[$st] ?? $st ?></span>
                    </div>
                </div>
                <?php if (!empty($r['harga'])): ?>
                <div class="ud-reservasi-harga">
                    <div class="ud-harga-amount">Rp <?= number_format($r['harga'], 0, ',', '.') ?></div>
                    <div class="ud-harga-label">Total Harga</div>
                </div>
                <?php endif; ?>
            </div>
            <div class="ud-reservasi-meta ud-reservasi-meta-detail">
                <span class="ud-meta-item">
                    <svg width="14" height="14" fill="none" stroke="#e84545" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div><div class="ud-meta-label">Tanggal Kunjungan</div><strong><?= date('l, j F Y', strtotime($r['tanggal'])) ?></strong></div>
                </span>
                <?php if (!empty($r['jam_mulai'])): ?>
                <span class="ud-meta-item">
                    <svg width="14" height="14" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                    <div><div class="ud-meta-label">Waktu</div><strong><?= date('H:i', strtotime($r['jam_mulai'])) ?> WIB</strong></div>
                </span>
                <?php endif; ?>
                <?php if (!empty($r['jumlah_peserta'])): ?>
                <span class="ud-meta-item">
                    <svg width="14" height="14" fill="none" stroke="#10b981" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <div><div class="ud-meta-label">Jumlah Orang</div><strong><?= $r['jumlah_peserta'] ?> Orang</strong></div>
                </span>
                <?php endif; ?>
            </div>
            <?php if ($st === 'terjadwal'): ?>
            <div class="ud-reservasi-actions">
                <button class="ud-btn-red-full" onclick="openETicket(
                    '<?= htmlspecialchars(addslashes($r['kode_booking'] ?? 'N/A')) ?>',
                    '<?= htmlspecialchars(addslashes($r['nama_kegiatan'])) ?>',
                    '<?= date('l, j F Y', strtotime($r['tanggal'])) ?>',
                    '<?= $r['jumlah_peserta'] ?? 1 ?>',
                    '<?= htmlspecialchars(addslashes($_SESSION['nama'] ?? '')) ?>',
                    '<?= htmlspecialchars(addslashes($_SESSION['email'] ?? '')) ?>'
                )">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                    Lihat E-Ticket
                </button>
                <button class="ud-btn-outline-sm" onclick="openETicket(
                    '<?= htmlspecialchars(addslashes($r['kode_booking'] ?? 'N/A')) ?>',
                    '<?= htmlspecialchars(addslashes($r['nama_kegiatan'])) ?>',
                    '<?= date('l, j F Y', strtotime($r['tanggal'])) ?>',
                    '<?= $r['jumlah_peserta'] ?? 1 ?>',
                    '<?= htmlspecialchars(addslashes($_SESSION['nama'] ?? '')) ?>',
                    '<?= htmlspecialchars(addslashes($_SESSION['email'] ?? '')) ?>'
                )">Detail</button>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="ud-card">
            <div class="ud-empty-state ud-empty-large">
                <div class="ud-empty-icon-gradient" style="background:linear-gradient(135deg,#ff6b6b,#f5a623);">
                    <svg width="36" height="36" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="ud-empty-title">Belum Ada Reservasi</h3>
                <p class="ud-empty-desc">Tambahkan reservasi baru untuk kunjungan Anda!</p>
                <button class="ud-btn-red" onclick="openReservasiModal()">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Reservasi
                </button>
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- ═══ MODAL FORM RESERVASI ═══ -->
<div class="ud-modal-overlay" id="reservasiModal" onclick="closeReservasiModal(event)">
    <div class="ud-modal" style="max-width:460px;width:94%;">
        <div class="ud-modal-icon" style="background:linear-gradient(135deg,#ff6b6b,#f5a623);">
            <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h2 class="ud-modal-title">Buat Reservasi</h2>
        <p class="ud-modal-desc">Isi data kunjungan Anda. Kode booking akan dikirim setelah disubmit.</p>
        <form action="index.php?page=user_submit_reservasi" method="POST" style="text-align:left;">
            <div style="margin-bottom:14px;">
                <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Nama Kegiatan / Acara</label>
                <input type="text" name="nama_kegiatan" required placeholder="cth: Kunjungan Keluarga"
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:Poppins,sans-serif;font-size:.85rem;outline:none;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Tanggal Kunjungan</label>
                <input type="date" name="tanggal" required
                       min="<?= date('Y-m-d') ?>"
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:Poppins,sans-serif;font-size:.85rem;outline:none;">
            </div>
            <div style="margin-bottom:14px;">
                <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" required min="1" max="500" value="2"
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:Poppins,sans-serif;font-size:.85rem;outline:none;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:4px;">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Info tambahan..."
                          style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:Poppins,sans-serif;font-size:.85rem;outline:none;resize:vertical;"></textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="closeReservasiModal()" class="ud-btn-outline-sm" style="flex:1;">Batal</button>
                <button type="submit" class="ud-btn-red" style="flex:1;justify-content:center;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
                    Kirim Reservasi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ MODAL E-TICKET ═══ -->
<div class="ud-modal-overlay" id="eticketModal" onclick="closeETicket(event)">
    <div class="ud-modal" id="eticketBox" style="max-width:480px;width:94%;padding:0;overflow:hidden;border-radius:20px;">

        <!-- Header tiket -->
        <div style="background:linear-gradient(135deg,#ff6b6b,#e84545,#f5a623);padding:24px 28px 20px;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-20px;right:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.07);"></div>
            <div style="position:absolute;bottom:-30px;left:60px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.05);"></div>
            <div style="display:flex;align-items:center;gap:12px;position:relative;">
                <div style="width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                </div>
                <div>
                    <div style="font-size:.7rem;color:rgba(255,255,255,.7);letter-spacing:1px;text-transform:uppercase;font-weight:600;">Wonderland Samarinda</div>
                    <div style="font-size:1.15rem;font-weight:800;color:white;line-height:1.2;">E-Ticket Reservasi</div>
                </div>
            </div>
            <!-- Status badge -->
            <div style="margin-top:14px;position:relative;">
                <span style="background:rgba(255,255,255,.2);color:white;font-size:.7rem;font-weight:700;padding:4px 12px;border-radius:20px;border:1px solid rgba(255,255,255,.3);">
                    ✓ DIKONFIRMASI
                </span>
            </div>
        </div>


        <div style="display:flex;align-items:center;background:#f8f7f4;">
            <div style="width:20px;height:20px;background:white;border-radius:50%;margin-left:-10px;flex-shrink:0;box-shadow:inset 2px 0 4px rgba(0,0,0,.08);"></div>
            <div style="flex:1;border-top:2px dashed #e5e7eb;margin:0 4px;"></div>
            <div style="width:20px;height:20px;background:white;border-radius:50%;margin-right:-10px;flex-shrink:0;box-shadow:inset -2px 0 4px rgba(0,0,0,.08);"></div>
        </div>


        <div style="background:var(--bg, #faf9f7);padding:20px 28px 24px;">


            <div style="text-align:center;margin-bottom:18px;">
                <div style="font-size:1.1rem;font-weight:800;color:#1f2937;" id="et-nama"></div>
                <div style="font-size:.75rem;color:#6b7280;margin-top:3px;">Kunjungan ke Wonderland Samarinda</div>
            </div>


            <div style="display:flex;justify-content:center;margin-bottom:18px;">
                <div style="background:white;border-radius:14px;padding:14px;box-shadow:0 2px 12px rgba(0,0,0,.08);text-align:center;">
                    <div id="et-qrcode" style="width:130px;height:130px;margin:0 auto;"></div>
                    <div id="et-kode" style="font-size:.85rem;font-weight:800;color:#e84545;letter-spacing:2px;margin-top:8px;font-family:monospace;"></div>
                    <div style="font-size:.62rem;color:#9ca3af;margin-top:2px;">Kode Booking</div>
                </div>
            </div>


            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px;">
                <div style="background:white;border-radius:10px;padding:12px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <div style="font-size:.62rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Nama Pemesan</div>
                    <div style="font-size:.82rem;font-weight:700;color:#1f2937;margin-top:3px;" id="et-user"></div>
                </div>
                <div style="background:white;border-radius:10px;padding:12px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <div style="font-size:.62rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Tanggal Kunjungan</div>
                    <div style="font-size:.82rem;font-weight:700;color:#1f2937;margin-top:3px;" id="et-tanggal"></div>
                </div>
                <div style="background:white;border-radius:10px;padding:12px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <div style="font-size:.62rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Jumlah Peserta</div>
                    <div style="font-size:.82rem;font-weight:700;color:#1f2937;margin-top:3px;" id="et-peserta"></div>
                </div>
                <div style="background:white;border-radius:10px;padding:12px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <div style="font-size:.62rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;font-weight:600;">Lokasi</div>
                    <div style="font-size:.82rem;font-weight:700;color:#1f2937;margin-top:3px;">Wonderland SMD</div>
                </div>
            </div>


            <div style="background:#fef3c7;border:1px solid #fcd34d;border-radius:10px;padding:10px 14px;display:flex;align-items:flex-start;gap:8px;margin-bottom:18px;">
                <svg width="16" height="16" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div style="font-size:.75rem;color:#92400e;line-height:1.5;">Tunjukkan e-ticket ini kepada petugas saat tiba di lokasi. Simpan sebagai pdf atau screenshot halaman ini.</div>
            </div>


            <div style="display:flex;gap:10px;">
                <button id="btn-save-pdf" onclick="saveETicketPDF()" style="flex:1;display:flex;align-items:center;justify-content:center;gap:6px;background:linear-gradient(135deg,#ff6b6b,#e84545);color:white;border:none;padding:11px;border-radius:40px;font-size:.82rem;font-weight:600;font-family:"Plus Jakarta Sans",sans-serif;cursor:pointer;box-shadow:0 4px 16px rgba(255,107,107,.3);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Simpan sebagai PDF
                </button>
                <button onclick="closeETicket()" style="padding:11px 18px;background:white;color:#6b7280;border:1.5px solid #e5e7eb;border-radius:9px;font-size:.82rem;font-weight:500;font-family:Poppins,sans-serif;cursor:pointer;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

var etState = {};

function openETicket(kode, nama, tanggal, peserta, namaUser, email) {
    etState = { kode, nama, tanggal, peserta, namaUser, email };

    document.getElementById('et-kode').textContent    = kode;
    document.getElementById('et-nama').textContent    = nama;
    document.getElementById('et-tanggal').textContent = tanggal;
    document.getElementById('et-peserta').textContent = peserta + ' Orang';
    document.getElementById('et-user').textContent    = namaUser;


    var qrDiv = document.getElementById('et-qrcode');
    qrDiv.innerHTML = '<img id="et-qr-img" src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=' +
        encodeURIComponent('WONDERLAND-SMD|' + kode + '|' + nama + '|' + tanggal) +
        '" width="130" height="130" style="border-radius:6px;" crossorigin="anonymous" alt="QR Code">';

    document.getElementById('eticketModal').classList.add('active');
}

function closeETicket(e) {
    if (!e || e.target === document.getElementById('eticketModal')) {
        document.getElementById('eticketModal').classList.remove('active');
    }
}

function saveETicketPDF() {
    var btn = document.getElementById('btn-save-pdf');
    btn.classList.add('et-generating');
    btn.innerHTML = '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg> Membuat PDF...';

    var s = etState;
    var { jsPDF } = window.jspdf;
    var doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: [100, 180] });

    var W = 100;


    doc.setFillColor(220, 38, 38);
    doc.rect(0, 0, W, 52, 'F');


    doc.setFillColor(255, 255, 255, 0.05);
    doc.setDrawColor(255, 255, 255);
    doc.setLineWidth(0);
    doc.setFillColor(200, 30, 30);
    doc.circle(W - 10, 8, 18, 'F');
    doc.circle(20, 52, 22, 'F');


    doc.setFont('helvetica', 'bold');
    doc.setFontSize(7);
    doc.setTextColor(255, 220, 220);
    doc.text('WONDERLAND SAMARINDA', W / 2, 14, { align: 'center' });

    doc.setFontSize(14);
    doc.setTextColor(255, 255, 255);
    doc.text('E-TICKET', W / 2, 24, { align: 'center' });

    doc.setFontSize(7);
    doc.setTextColor(255, 220, 220);
    doc.text('RESERVASI KUNJUNGAN', W / 2, 31, { align: 'center' });


    doc.setFillColor(180, 20, 20);
    doc.roundedRect(W/2 - 22, 35, 44, 10, 5, 5, 'F');
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(7);
    doc.setTextColor(255, 255, 255);
    doc.text('DIKONFIRMASI', W / 2, 41.5, { align: 'center' });


    doc.setDrawColor(200, 200, 200);
    doc.setLineDashPattern([2, 2], 0);
    doc.setLineWidth(0.4);
    doc.line(6, 52, W - 6, 52);
    doc.setLineDashPattern([], 0);


    doc.setFillColor(248, 247, 244);
    doc.circle(0, 52, 4, 'F');
    doc.circle(W, 52, 4, 'F');


    doc.setFillColor(248, 247, 244);
    doc.rect(0, 52, W, 128, 'F');

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(10);
    doc.setTextColor(31, 41, 55);
    var namaLines = doc.splitTextToSize(s.nama, W - 16);
    doc.text(namaLines, W / 2, 62, { align: 'center' });

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(6.5);
    doc.setTextColor(107, 114, 128);
    doc.text('Kunjungan ke Wonderland Samarinda', W / 2, 68, { align: 'center' });


    var qrImg = document.getElementById('et-qr-img');
    var drawQR = function() {
        try {

            doc.setFillColor(255, 255, 255);
            doc.roundedRect(W/2 - 22, 71, 44, 52, 4, 4, 'F');
            doc.addImage(qrImg, 'PNG', W/2 - 18, 74, 36, 36);
        } catch(e) {

            doc.setFillColor(245, 245, 245);
            doc.roundedRect(W/2 - 22, 71, 44, 52, 4, 4, 'F');
            doc.setFontSize(6);
            doc.setTextColor(150, 150, 150);
            doc.text('[QR Code]', W/2, 97, { align: 'center' });
        }


        doc.setFont('helvetica', 'bold');
        doc.setFontSize(11);
        doc.setTextColor(220, 38, 38);
        doc.text(s.kode, W / 2, 116, { align: 'center' });

        doc.setFont('helvetica', 'normal');
        doc.setFontSize(6);
        doc.setTextColor(156, 163, 175);
        doc.text('KODE BOOKING', W / 2, 120, { align: 'center' });


        var gY = 127;
        var gH = 14;
        var gPad = 3;

        var drawCell = function(x, y, w, label, val) {
            doc.setFillColor(255, 255, 255);
            doc.roundedRect(x, y, w, gH, 2, 2, 'F');
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(5.5);
            doc.setTextColor(156, 163, 175);
            doc.text(label.toUpperCase(), x + gPad, y + 5);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(6.5);
            doc.setTextColor(31, 41, 55);
            var lines = doc.splitTextToSize(val, w - gPad * 2);
            doc.text(lines[0], x + gPad, y + 10.5);
        };

        var col1x = 4, col2x = W / 2 + 2, colW = W / 2 - 6;
        drawCell(col1x, gY,      colW, 'Nama Pemesan',    s.namaUser);
        drawCell(col2x, gY,      colW, 'Jumlah Peserta',  s.peserta + ' Orang');
        drawCell(col1x, gY + gH + 3, colW, 'Tanggal Kunjungan', s.tanggal);
        drawCell(col2x, gY + gH + 3, colW, 'Lokasi',           'Wonderland SMD');


        var noteY = gY + gH * 2 + 10;
        doc.setFillColor(254, 243, 199);
        doc.roundedRect(4, noteY, W - 8, 12, 2, 2, 'F');
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(5.5);
        doc.setTextColor(146, 64, 14);
        var note = 'Tunjukkan e-ticket ini kepada petugas saat tiba di lokasi.';
        var noteLines = doc.splitTextToSize(note, W - 14);
        doc.text(noteLines, 7, noteY + 5);


        doc.setFillColor(220, 38, 38);
        doc.rect(0, 172, W, 8, 'F');
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(5.5);
        doc.setTextColor(255, 220, 220);
        doc.text('wonderland-samarinda.id  •  Jl. Untung Suropati, Loa Bakung', W / 2, 177, { align: 'center' });


        doc.save('eticket-' + s.kode + '.pdf');

        btn.classList.remove('et-generating');
        btn.innerHTML = '<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7,10 12,15 17,10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Simpan sebagai PDF';
    };


    if (qrImg && qrImg.complete && qrImg.naturalWidth > 0) {
        drawQR();
    } else if (qrImg) {
        qrImg.onload  = drawQR;
        qrImg.onerror = drawQR;

        setTimeout(drawQR, 3000);
    } else {
        drawQR();
    }
}
</script>

<script>
function openReservasiModal() {
    document.getElementById('reservasiModal').classList.add('active');
}
function closeReservasiModal(e) {
    if (!e || e.target === document.getElementById('reservasiModal')) {
        document.getElementById('reservasiModal').classList.remove('active');
    }
}
</script>
<script src="assets/js/enhance.js"></script>
    <script src="assets/js/user.js"></script>
</body>
</html>
