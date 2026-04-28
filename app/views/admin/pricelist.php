<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){try{var t=localStorage.getItem('wl_theme')||'light';document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
    <title>Kelola Daftar Harga - Wonderland Admin</title>
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
                <h1 class="adm-page-title">Kelola Daftar Harga</h1>
                <p class="adm-page-sub">Manage harga tiket & layanan</p>
            </div>
            <button class="adm-btn adm-btn-primary" onclick="openModal('modalTambah')">
                <i class="fas fa-plus"></i> Tambah Item
            </button>
        </div>

        <?php if (isset($_GET['ok'])): ?>
        <div class="adm-alert-success">
            <i class="fas fa-check-circle"></i>
            Item harga berhasil <?= $_GET['ok'] === 'hapus' ? 'dihapus' : ($_GET['ok'] === 'edit' ? 'diupdate' : 'ditambahkan') ?>!
        </div>
        <?php endif; ?>


        <div class="adm-card" style="margin-bottom:20px; padding:16px 20px;">
            <form method="GET" action="index.php" class="adm-filter-bar">
                <input type="hidden" name="page" value="admin_pricelist">
                <div class="adm-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="adm-search-input"
                           placeholder="Cari item harga..."
                           value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
            </form>
        </div>

        <?php

        $grouped = [];
        foreach ($price_items as $item) {
            $grouped[$item['kategori']][] = $item;
        }

        $cat_icons = [
            'Tiket Masuk' => 'fas fa-ticket-alt',
            'Wahana'      => 'fas fa-star',
            'Parking'     => 'fas fa-car',
            'default'     => 'fas fa-dollar-sign',
        ];
        ?>

        <?php if (empty($price_items)): ?>
            <div class="adm-card adm-empty">Belum ada data harga. Klik "Tambah Item" untuk mulai.</div>
        <?php else: ?>
            <?php foreach ($grouped as $kategori => $items): ?>
            <div class="adm-price-category">
                <div class="adm-price-cat-header">
                    <i class="<?= $cat_icons[$kategori] ?? $cat_icons['default'] ?>"></i>
                    <span class="adm-price-cat-name">$ <?= htmlspecialchars($kategori) ?></span>
                </div>
                <div class="adm-price-list-body">
                    <?php foreach ($items as $item): ?>
                    <div class="adm-price-item">
                        <div style="flex:1">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                                <p class="adm-price-name"><?= htmlspecialchars($item['nama']) ?></p>
                                <span class="adm-badge adm-badge-<?= strtolower($item['status'] ?? 'aktif') ?>" style="font-size:.68rem">
                                    <?= ucfirst($item['status'] ?? 'Aktif') ?>
                                </span>
                            </div>
                            <p class="adm-price-desc"><?= htmlspecialchars($item['deskripsi'] ?? '') ?></p>
                            <div class="adm-price-cols" style="margin-top:8px">
                                <div class="adm-price-col">
                                    <label>Harga Normal</label>
                                    <span>Rp <?= number_format($item['harga_normal'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                                <div class="adm-price-col">
                                    <label>Harga Promo</label>
                                    <span>Rp <?= number_format($item['harga_promo'] ?? 0, 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="adm-price-item-actions">
                            <button class="adm-btn-icon edit"
                                    onclick='openEditModal(<?= json_encode($item) ?>)'
                                    title="Edit">
                                <i class="far fa-edit"></i>
                            </button>
                            <form method="POST" action="index.php?page=admin_pricelist"
                                  onsubmit="return confirm('Hapus item ini?')"
                                  style="display:inline">
                                <input type="hidden" name="action" value="hapus">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <button type="submit" class="adm-btn-icon del" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>
</div>

<!-- Modal Tambah -->
<div class="adm-modal-overlay" id="modalTambah">
    <div class="adm-modal">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">Tambah Item Harga</h3>
            <button class="adm-modal-close" onclick="closeModal('modalTambah')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_pricelist">
            <input type="hidden" name="action" value="tambah">
            <div class="adm-form-group">
                <label>Nama Item</label>
                <input type="text" name="nama" required placeholder="Contoh: Tiket Dewasa">
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Keterangan item harga..."></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Kategori</label>
                    <select name="kategori">
                        <option value="Tiket Masuk">Tiket Masuk</option>
                        <option value="Wahana">Wahana</option>
                        <option value="Parking">Parking</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Harga Normal (Rp)</label>
                    <input type="number" name="harga_normal" placeholder="75000">
                </div>
                <div class="adm-form-group">
                    <label>Harga Promo (Rp)</label>
                    <input type="number" name="harga_promo" placeholder="55000">
                </div>
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
            <h3 class="adm-modal-title">Edit Item Harga</h3>
            <button class="adm-modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_pricelist">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="adm-form-group">
                <label>Nama Item</label>
                <input type="text" name="nama" id="edit_nama" required>
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi"></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Kategori</label>
                    <select name="kategori" id="edit_kategori">
                        <option value="Tiket Masuk">Tiket Masuk</option>
                        <option value="Wahana">Wahana</option>
                        <option value="Parking">Parking</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Harga Normal (Rp)</label>
                    <input type="number" name="harga_normal" id="edit_harga_normal">
                </div>
                <div class="adm-form-group">
                    <label>Harga Promo (Rp)</label>
                    <input type="number" name="harga_promo" id="edit_harga_promo">
                </div>
            </div>
            <div class="adm-form-actions">
                <button type="button" class="adm-btn-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="adm-btn-save">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id)  { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }

function openEditModal(d) {
    document.getElementById('edit_id').value           = d.id;
    document.getElementById('edit_nama').value         = d.nama;
    document.getElementById('edit_deskripsi').value    = d.deskripsi || '';
    document.getElementById('edit_kategori').value     = d.kategori;
    document.getElementById('edit_status').value       = d.status || 'aktif';
    document.getElementById('edit_harga_normal').value = d.harga_normal || 0;
    document.getElementById('edit_harga_promo').value  = d.harga_promo || 0;
    openModal('modalEdit');
}

<?php if (isset($_GET['modal'])): ?>
openModal('modalTambah');
<?php endif; ?>
</script>
<script src="assets/js/enhance.js"></script>
</body>
</html>
