<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){try{var t=localStorage.getItem('wl_theme')||'light';document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
    <title>Kelola Wahana - Wonderland Admin</title>
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
                <h1 class="adm-page-title">Kelola Wahana</h1>
                <p class="adm-page-sub">Manage semua wahana & atraksi</p>
            </div>
            <button class="adm-btn adm-btn-primary" onclick="openModal('modalTambah')">
                <i class="fas fa-plus"></i> Tambah Wahana
            </button>
        </div>

        <?php if (isset($_GET['ok'])): ?>
        <div style="background:#D1FAE5;color:#065F46;padding:12px 18px;border-radius:10px;margin-bottom:18px;font-size:.85rem;font-weight:600;">
            <i class="fas fa-check-circle"></i> Wahana berhasil <?= $_GET['ok'] === 'hapus' ? 'dihapus' : ($_GET['ok'] === 'edit' ? 'diupdate' : 'ditambahkan') ?>!
        </div>
        <?php endif; ?>


        <div class="adm-card" style="margin-bottom:20px;padding:16px 20px;">
            <form method="GET" action="index.php" class="adm-filter-bar" style="margin:0">
                <input type="hidden" name="page" value="admin_wahana">
                <div class="adm-search-wrap" style="max-width:100%">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="adm-search-input" placeholder="Cari wahana..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </form>
        </div>


        <div class="adm-wahana-grid">
            <?php if (empty($wahanas)): ?>
                <p class="adm-empty" style="grid-column:1/-1">Belum ada wahana</p>
            <?php else: ?>
            <?php foreach ($wahanas as $w): ?>
            <div class="adm-wahana-card">
                <div class="adm-wahana-thumb">
                    <?php if ($w['foto']): ?>
                        <?php
                        $uploadPath = 'uploads/wahana/' . $w['foto'];
                        $assetPath = 'assets/wahana/' . $w['foto'];
                        $fotoSrc = file_exists($_SERVER['DOCUMENT_ROOT'] . '/progress-web-wonderland/' . $uploadPath)
                            ? $uploadPath
                            : $assetPath;
                        ?>
<img src="<?= htmlspecialchars($fotoSrc) ?>" alt="<?= htmlspecialchars($w['nama']) ?>">
                    <?php else: ?>
                        <i class="far fa-image"></i>
                    <?php endif; ?>
                </div>
                <div class="adm-wahana-body">
                    <div class="adm-wahana-card-header">
                        <h4 class="adm-wahana-card-name"><?= htmlspecialchars($w['nama']) ?></h4>
                        <span class="adm-badge adm-badge-<?= strtolower($w['status']) ?>"><?= ucfirst($w['status']) ?></span>
                    </div>
                    <p class="adm-wahana-card-desc"><?= htmlspecialchars($w['deskripsi']) ?></p>
                    <div class="adm-wahana-detail">
                        <span>Kategori:</span>
                        <span class="adm-wahana-detail-val"><?= htmlspecialchars($w['kategori']) ?></span>
                    </div>
                    <div class="adm-wahana-detail">
                        <span>Harga:</span>
                        <span class="adm-wahana-detail-val price">Rp <?= number_format($w['harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="adm-wahana-detail">
                        <span>Jam Operasional:</span>
                        <span class="adm-wahana-detail-val"><?= htmlspecialchars($w['jam_operasional']) ?></span>
                    </div>
                    <div class="adm-wahana-actions">
                        <button class="adm-btn adm-btn-edit" onclick='openEditModal(<?= json_encode($w) ?>)'>
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <form method="POST" action="index.php?page=admin_wahana" onsubmit="return confirm('Hapus wahana ini?')">
                            <input type="hidden" name="action" value="hapus">
                            <input type="hidden" name="id" value="<?= $w['id'] ?>">
                            <button type="submit" class="adm-btn adm-btn-delete"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div class="adm-modal-overlay" id="modalTambah">
    <div class="adm-modal">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">Tambah Wahana</h3>
            <button class="adm-modal-close" onclick="closeModal('modalTambah')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_wahana" enctype="multipart/form-data">
            <input type="hidden" name="action" value="tambah">
            <div class="adm-form-group">
                <label>Nama Wahana</label>
                <input type="text" name="nama" required placeholder="Thunder Coaster">
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi wahana..."></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" placeholder="Extreme Thrill">
                </div>
                <div class="adm-form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="50000">
                </div>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Jam Operasional</label>
                    <input type="text" name="jam_operasional" placeholder="3 menit 30 detik">
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" class="adm-search-input" style="padding-left:14px">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-group">
                <label>foto Wahana</label>
                <input type="file" name="foto" accept="image/*">
            </div>
            <div class="adm-form-actions">
                <button type="button" class="adm-btn-cancel" onclick="closeModal('modalTambah')">Batal</button>
                <button type="submit" class="adm-btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="adm-modal-overlay" id="modalEdit">
    <div class="adm-modal">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">Edit Wahana</h3>
            <button class="adm-modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_wahana" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <input type="hidden" name="foto_lama" id="edit_foto_lama">
            <div class="adm-form-group">
                <label>Nama Wahana</label>
                <input type="text" name="nama" id="edit_nama" required>
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi"></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Kategori</label>
                    <input type="text" name="kategori" id="edit_kategori">
                </div>
                <div class="adm-form-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" id="edit_harga">
                </div>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>jam_operasional</label>
                    <input type="text" name="jam_operasional" id="edit_jam_operasional">
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="adm-search-input" style="padding-left:14px">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-group">
                <label>Ganti foto (kosongkan jika tidak diganti)</label>
                <input type="file" name="foto" accept="image/*">
            </div>
            <div class="adm-form-actions">
                <button type="button" class="adm-btn-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="adm-btn-save">Update</button>
            </div>
        </form>
    </div>
</div>

<button class="adm-help-btn">?</button>
<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function openEditModal(d) {
    document.getElementById('edit_id').value          = d.id;
    document.getElementById('edit_nama').value        = d.nama;
    document.getElementById('edit_deskripsi').value   = d.deskripsi;
    document.getElementById('edit_kategori').value    = d.kategori;
    document.getElementById('edit_harga').value       = d.harga;
    document.getElementById('edit_jam_operasional').value      = d.jam_operasional;
    document.getElementById('edit_status').value      = d.status;
    document.getElementById('edit_foto_lama').value = d.foto;
    openModal('modalEdit');
}
<?php if (isset($_GET['modal'])): ?>openModal('modalTambah');<?php endif; ?>
</script>
<script src="assets/js/enhance.js"></script>
</body>
</html>
