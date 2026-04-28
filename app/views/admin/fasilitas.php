<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>(function(){try{var t=localStorage.getItem('wl_theme')||'light';document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;}catch(e){document.documentElement.setAttribute('data-theme','light');}})();</script>
    <title>Kelola Fasilitas - Wonderland Admin</title>
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
                <h1 class="adm-page-title">Kelola Fasilitas</h1>
                <p class="adm-page-sub">Manage semua fasilitas taman</p>
            </div>
            <button class="adm-btn adm-btn-primary" onclick="openModal('modalTambah')">
                <i class="fas fa-plus"></i> Tambah Fasilitas
            </button>
        </div>

        <?php if (isset($_GET['ok'])): ?>
        <div style="background:#D1FAE5;color:#065F46;padding:12px 18px;border-radius:10px;margin-bottom:18px;font-size:.85rem;font-weight:600;">
            <i class="fas fa-check-circle"></i> Fasilitas berhasil <?= $_GET['ok'] === 'hapus' ? 'dihapus' : ($_GET['ok'] === 'edit' ? 'diupdate' : 'ditambahkan') ?>!
        </div>
        <?php endif; ?>

        <div class="adm-card" style="margin-bottom:16px;padding:16px 20px;">
            <form method="GET" action="index.php" class="adm-filter-bar" style="margin:0">
                <input type="hidden" name="page" value="admin_fasilitas">
                <div class="adm-search-wrap" style="max-width:100%">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="adm-search-input" placeholder="Cari fasilitas..." value="<?= htmlspecialchars($search) ?>">
                </div>
            </form>
        </div>

        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Fasilitas</th>
                        <th>Tipe</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($fasilitas_list)): ?>
                    <tr><td colspan="6" class="adm-empty">Belum ada fasilitas</td></tr>
                <?php else: ?>
                <?php foreach ($fasilitas_list as $f): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td>
                        <p class="adm-td-name"><?= htmlspecialchars($f['nama']) ?></p>
                        <p class="adm-td-sub"><?= htmlspecialchars($f['deskripsi']) ?></p>
                    </td>
                    <td><span class="adm-badge adm-badge-<?= strtolower($f['ikon']) ?>"><?= htmlspecialchars($f['ikon']) ?></span></td>
                    <td><?= htmlspecialchars($f['deskripsi']) ?></td>
                    <td><span class="adm-badge adm-badge-<?= strtolower($f['status']) ?>"><?= ucfirst($f['status']) ?></span></td>
                    <td>
                        <div class="adm-td-actions">
                            <button class="adm-btn-icon edit" onclick='openEditModal(<?= json_encode($f) ?>)'><i class="far fa-edit"></i></button>
                            <button class="adm-btn-icon del" onclick="confirmHapus(<?= $f['id'] ?>, '<?= htmlspecialchars(addslashes($f['nama'])) ?>')"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div class="adm-modal-overlay" id="modalTambah">
    <div class="adm-modal">
        <div class="adm-modal-header">
            <h3 class="adm-modal-title">Tambah Fasilitas</h3>
            <button class="adm-modal-close" onclick="closeModal('modalTambah')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_fasilitas">
            <input type="hidden" name="action" value="tambah">
            <div class="adm-form-group">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama" required placeholder="Food Court Central">
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" placeholder="Deskripsi fasilitas..."></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Tipe</label>
                    <select name="ikon" class="adm-search-input" style="padding-left:14px">
                        <option value="Dining">Dining</option>
                        <option value="Religious">Religious</option>
                        <option value="Medical">Medical</option>
                        <option value="Parking">Parking</option>
                        <option value="Toilet">Toilet</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" class="adm-search-input" style="padding-left:14px">
                        <option value="tersedia">Available</option>
                        <option value="tidak_tersedia">Unavailable</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-group">
                <label>Lokasi</label>
                <input type="text" name="ikon" placeholder="Area A - Near Main Entrance">
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
            <h3 class="adm-modal-title">Edit Fasilitas</h3>
            <button class="adm-modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <form method="POST" action="index.php?page=admin_fasilitas">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="adm-form-group">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama" id="edit_nama" required>
            </div>
            <div class="adm-form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi"></textarea>
            </div>
            <div class="adm-form-row">
                <div class="adm-form-group">
                    <label>Tipe</label>
                    <select name="ikon" id="edit_tipe" class="adm-search-input" style="padding-left:14px">
                        <option value="Dining">Dining</option>
                        <option value="Religious">Religious</option>
                        <option value="Medical">Medical</option>
                        <option value="Parking">Parking</option>
                        <option value="Toilet">Toilet</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="adm-search-input" style="padding-left:14px">
                        <option value="tersedia">Available</option>
                        <option value="tidak_tersedia">Unavailable</option>
                    </select>
                </div>
            </div>
            <div class="adm-form-group">
                <label>Lokasi</label>
                <input type="text" name="ikon" id="edit_lokasi">
            </div>
            <div class="adm-form-actions">
                <button type="button" class="adm-btn-cancel" onclick="closeModal('modalEdit')">Batal</button>
                <button type="submit" class="adm-btn-save">Update</button>
            </div>
        </form>
    </div>
</div>

<button class="adm-help-btn">?</button>

<!-- Modal Konfirmasi Hapus -->
<div class="adm-modal-overlay" id="modalHapus">
    <div class="adm-modal" style="max-width:420px">
        <div class="adm-modal-header" style="border-bottom:none;padding-bottom:0">
            <button class="adm-modal-close" onclick="closeModal('modalHapus')">&times;</button>
        </div>
        <div style="text-align:center;padding:8px 28px 28px">
            <div style="width:60px;height:60px;background:#FEE2E2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                <i class="fas fa-trash" style="color:#DC2626;font-size:1.4rem"></i>
            </div>
            <h3 style="font-size:1.05rem;font-weight:700;margin-bottom:8px;color:var(--adm-text,#111)">Hapus Fasilitas?</h3>
            <p style="font-size:.85rem;color:#6B7280;margin-bottom:24px">
                Yakin ingin menghapus <strong id="hapusNama"></strong>?<br>Tindakan ini tidak bisa dibatalkan.
            </p>
            <div style="display:flex;gap:10px;justify-content:center">
                <button class="adm-btn-cancel" onclick="closeModal('modalHapus')" style="padding:10px 24px;border-radius:8px">Batal</button>
                <button class="adm-btn-save" onclick="submitHapus()" style="padding:10px 24px;border-radius:8px;background:#DC2626;border-color:#DC2626">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form untuk submit hapus -->
<form id="formHapus" method="POST" action="index.php?page=admin_fasilitas" style="display:none">
    <input type="hidden" name="action" value="hapus">
    <input type="hidden" name="id" id="hapusId">
</form>

<script>
function openModal(id) { document.getElementById(id).classList.add('show'); }
function closeModal(id) { document.getElementById(id).classList.remove('show'); }
function confirmHapus(id, nama) {
    document.getElementById('hapusId').value   = id;
    document.getElementById('hapusNama').textContent = nama;
    openModal('modalHapus');
}
function submitHapus() {
    document.getElementById('formHapus').submit();
}
function openEditModal(d) {
    document.getElementById('edit_id').value        = d.id;
    document.getElementById('edit_nama').value      = d.nama;
    document.getElementById('edit_deskripsi').value = d.deskripsi;
    document.getElementById('edit_tipe').value      = d.ikon;
    document.getElementById('edit_lokasi').value    = d.ikon;
    document.getElementById('edit_status').value    = d.status;
    openModal('modalEdit');
}
</script>
<script src="assets/js/enhance.js"></script>
</body>
</html>
