<?php

require_once __DIR__ . '/../models/ReservasiModel.php';
require_once __DIR__ . '/../models/UlasanModel.php';
class AdminController
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    private function requireAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }
    }

    private function fetchAllAssoc(string $sql, string $types = '', array $params = []): array
    {
        if ($types === '' || empty($params)) {
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $rows;
    }

    public function dashboard(): void
{
    $this->requireAdmin();
    $active_page = 'dashboard';

    $total_reservasi = $this->db->query("SELECT COUNT(*) FROM reservasi")->fetch_row()[0] ?? 0;
    $wahana_aktif = $this->db->query("SELECT COUNT(*) FROM wahana WHERE status='aktif'")->fetch_row()[0] ?? 0;

    $pengunjung_hari = 0;
    $revenue = 0;

    $res_terbaru = $this->db->query(
        "SELECT * FROM reservasi ORDER BY created_at DESC LIMIT 5"
    )->fetch_all(MYSQLI_ASSOC);

    $wahana_populer = $this->db->query(
        "SELECT * FROM wahana WHERE status='aktif' ORDER BY created_at DESC LIMIT 5"
    )->fetch_all(MYSQLI_ASSOC);

    require __DIR__ . '/../views/admin/dashboard.php';
}

    public function wahana(): void
    {
        $this->requireAdmin();
        $active_page = 'wahana';

        $action = $_POST['action'] ?? '';
        if ($action === 'tambah') {
            $gambar = '';
            if (!empty($_FILES['foto']['name'])) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $gambar = 'wahana_' . time() . '.' . $ext;
            $folder = __DIR__ . '/../../uploads/wahana/';
            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }
            move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $gambar);
        }

            $stmt = $this->db->prepare("INSERT INTO wahana (nama, deskripsi, kategori, harga, jam_operasional, status, foto) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $_POST['nama'], $_POST['deskripsi'], $_POST['kategori'], $_POST['harga'], $_POST['jam_operasional'], $_POST['status'], $gambar);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_wahana&ok=tambah');
            exit;
        }

        if ($action === 'edit') {
            $gambar = $_POST['foto_lama'] ?? '';
            if (!empty($_FILES['foto']['name'])) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $gambar = 'wahana_' . time() . '.' . $ext;
            $folder = __DIR__ . '/../../uploads/wahana/';
            if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
            }
            move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $gambar);
        }

            $stmt = $this->db->prepare("UPDATE wahana SET nama=?, deskripsi=?, kategori=?, harga=?, jam_operasional=?, status=?, foto=? WHERE id=?");
            $stmt->bind_param("sssssssi", $_POST['nama'], $_POST['deskripsi'], $_POST['kategori'], $_POST['harga'], $_POST['jam_operasional'], $_POST['status'], $gambar, $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_wahana&ok=edit');
            exit;
        }

        if ($action === 'hapus') {
            $stmt = $this->db->prepare("DELETE FROM wahana WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_wahana&ok=hapus');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        $sql = "SELECT * FROM wahana";
        $types = '';
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE nama LIKE ?";
            $types = 's';
            $params[] = "%{$search}%";
        }
        $sql .= " ORDER BY nama";
        $wahanas = $this->fetchAllAssoc($sql, $types, $params);
        require __DIR__ . '/../views/admin/wahana.php';
    }

    public function fasilitas(): void
    {
        $this->requireAdmin();
        $active_page = 'fasilitas';

        $action = $_POST['action'] ?? '';
        if ($action === 'tambah') {
            $stmt = $this->db->prepare("INSERT INTO fasilitas (nama, ikon, deskripsi, status) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $_POST['nama'], $_POST['ikon'], $_POST['deskripsi'], $_POST['status']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_fasilitas&ok=tambah');
            exit;
        }

        if ($action === 'edit') {
            $stmt = $this->db->prepare("UPDATE fasilitas SET nama=?, ikon=?, deskripsi=?, status=? WHERE id=?");
            $stmt->bind_param("ssssi", $_POST['nama'], $_POST['ikon'], $_POST['deskripsi'], $_POST['status'], $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_fasilitas&ok=edit');
            exit;
        }

        if ($action === 'hapus') {
            $stmt = $this->db->prepare("DELETE FROM fasilitas WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_fasilitas&ok=hapus');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        $sql = "SELECT * FROM fasilitas";
        $types = '';
        $params = [];
        if ($search !== '') {
            $sql .= " WHERE nama LIKE ?";
            $types = 's';
            $params[] = "%{$search}%";
        }
        $sql .= " ORDER BY id";
        $fasilitas_list = $this->fetchAllAssoc($sql, $types, $params);

        require __DIR__ . '/../views/admin/fasilitas.php';
    }

public function reservasi(): void
{
    $this->requireAdmin();
    $active_page = 'reservasi';

    $model = new ReservasiModel($this->db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'tambah') {
            $userId = !empty($_POST['user_id']) ? (int)$_POST['user_id'] : null;

            $checkCol = $this->db->query("SHOW COLUMNS FROM reservasi LIKE 'kode_booking'");
            if ($checkCol && $checkCol->num_rows === 0) {
                $this->db->query("ALTER TABLE reservasi ADD COLUMN kode_booking VARCHAR(20) DEFAULT NULL");
            }
            $kodeBooking = strtoupper(substr(md5(uniqid(($userId ?? 0) . time(), true)), 0, 10));
            $stmt = $this->db->prepare(
                "INSERT INTO reservasi (user_id, nama_kegiatan, jenis_kegiatan, tanggal, jam_mulai, jam_selesai, jumlah_peserta, keterangan, status, kode_booking, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->bind_param(
                "isssssisss",
                $userId,
                $_POST['nama_kegiatan'],
                $_POST['jenis_kegiatan'],
                $_POST['tanggal'],
                $_POST['jam_mulai'],
                $_POST['jam_selesai'],
                $_POST['jumlah_peserta'],
                $_POST['keterangan'],
                $_POST['status'],
                $kodeBooking
            );
            $stmt->execute();
            $stmt->close();
        }

        if ($action === 'edit') {
            $userId = !empty($_POST['user_id']) ? (int)$_POST['user_id'] : null;
            $stmt = $this->db->prepare(
                "UPDATE reservasi SET user_id=?, nama_kegiatan=?, jenis_kegiatan=?, tanggal=?, jam_mulai=?, jam_selesai=?, jumlah_peserta=?, keterangan=?, status=? WHERE id=?"
            );
            $stmt->bind_param(
                "isssssissi",
                $userId,
                $_POST['nama_kegiatan'],
                $_POST['jenis_kegiatan'],
                $_POST['tanggal'],
                $_POST['jam_mulai'],
                $_POST['jam_selesai'],
                $_POST['jumlah_peserta'],
                $_POST['keterangan'],
                $_POST['status'],
                $_POST['id']
            );
            $stmt->execute();
            $stmt->close();
        }

        if ($action === 'hapus') {
            $model->delete((int) $_POST['id']);
        }

        if ($action === 'update_status') {
            $model->updateStatus((int) $_POST['id'], $_POST['status']);
        }

        header('Location: index.php?page=admin_reservasi');
        exit;
    }

    $search = $_GET['search'] ?? '';
    $filter_status = $_GET['status'] ?? '';
    $reservasis = $model->getAll($search, $filter_status);
    $wahana_list = $this->db->query("SELECT id, nama FROM wahana WHERE status='aktif' ORDER BY nama")->fetch_all(MYSQLI_ASSOC);
    $user_list = $this->db->query("SELECT id, nama, email FROM users ORDER BY nama")->fetch_all(MYSQLI_ASSOC);

    require __DIR__ . '/../views/admin/reservasi.php';
}

    public function ulasan(): void
{
    $this->requireAdmin();
    $active_page = 'ulasan';

    $model = new UlasanModel($this->db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $id = (int) ($_POST['id'] ?? 0);
        if ($action === 'hapus') {
            $model->delete($id);
        }
        if ($action === 'update_status') {
            $model->updateStatus($id, $_POST['status']);
        }
        if ($action === 'approve') {
            $model->updateStatus($id, 'approved');
        }
        if ($action === 'hide') {
            $model->updateStatus($id, 'hidden');
        }
        if ($action === 'publish') {
            $model->updateStatus($id, 'approved');
        }
        header('Location: index.php?page=admin_ulasan');
        exit;
    }

    $ulasans = $model->getAll();
    $total = count($ulasans);
    $pub = count(array_filter($ulasans, fn($u) => $u['status'] === 'approved'));
    $pend = count(array_filter($ulasans, fn($u) => $u['status'] === 'pending'));
    $avg = count($ulasans) > 0 ? round(array_sum(array_column($ulasans, 'rating')) / count($ulasans), 1) : 0;
    $search = $_GET['search'] ?? '';
    $filter = $_GET['filter'] ?? '';

    require __DIR__ . '/../views/admin/ulasan.php';
}
    public function pricelist(): void
    {
        $this->requireAdmin();
        $active_page = 'pricelist';


        $this->db->query("
            CREATE TABLE IF NOT EXISTS pricelist (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(100) NOT NULL,
                deskripsi TEXT,
                kategori VARCHAR(50) NOT NULL DEFAULT 'Tiket Masuk',
                harga_normal INT NOT NULL DEFAULT 0,
                harga_promo INT NOT NULL DEFAULT 0,
                status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $action = $_POST['action'] ?? '';

        if ($action === 'tambah') {
            $harga_normal = (int)($_POST['harga_normal'] ?? 0);
            $harga_promo  = (int)($_POST['harga_promo']  ?? 0);
            $stmt = $this->db->prepare(
                "INSERT INTO pricelist (nama, deskripsi, kategori, harga_normal, harga_promo, status)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "sssiis",
                $_POST['nama'], $_POST['deskripsi'], $_POST['kategori'],
                $harga_normal, $harga_promo, $_POST['status']
            );
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_pricelist&ok=tambah');
            exit;
        }

        if ($action === 'edit') {
            $harga_normal = (int)($_POST['harga_normal'] ?? 0);
            $harga_promo  = (int)($_POST['harga_promo']  ?? 0);
            $stmt = $this->db->prepare(
                "UPDATE pricelist SET nama=?, deskripsi=?, kategori=?, harga_normal=?, harga_promo=?, status=? WHERE id=?"
            );
            $stmt->bind_param(
                "sssiisi",
                $_POST['nama'], $_POST['deskripsi'], $_POST['kategori'],
                $harga_normal, $harga_promo, $_POST['status'],
                $_POST['id']
            );
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_pricelist&ok=edit');
            exit;
        }

        if ($action === 'hapus') {
            $stmt = $this->db->prepare("DELETE FROM pricelist WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_pricelist&ok=hapus');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        $sql    = "SELECT * FROM pricelist";
        $types  = '';
        $params = [];
        if ($search !== '') {
            $sql   .= " WHERE nama LIKE ? OR deskripsi LIKE ? OR kategori LIKE ?";
            $like   = "%{$search}%";
            $types  = 'sss';
            $params = [$like, $like, $like];
        }
        $sql .= " ORDER BY kategori, nama";
        $price_items = $this->fetchAllAssoc($sql, $types, $params);

        require __DIR__ . '/../views/admin/pricelist.php';
    }

    public function fotoUser(): void
    {
        $this->requireAdmin();
        $active_page = 'foto_user';

        $action = $_POST['action'] ?? '';
        if ($action === 'approve') {
            $stmt = $this->db->prepare("UPDATE foto_pengunjung SET status='approved' WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_foto_user');
            exit;
        }
        if ($action === 'reject') {
            $stmt = $this->db->prepare("UPDATE foto_pengunjung SET status='rejected' WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_foto_user');
            exit;
        }
        if ($action === 'hapus') {
            $stmt = $this->db->prepare("SELECT nama_file FROM foto_pengunjung WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $f = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($f) {
                $path = __DIR__ . '/../../uploads/' . $f['nama_file'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $stmt = $this->db->prepare("DELETE FROM foto_pengunjung WHERE id=?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?page=admin_foto_user');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        $filter = trim($_GET['status'] ?? '');
        $sql = "SELECT fp.*, u.nama, u.email
                FROM foto_pengunjung fp
                LEFT JOIN users u ON fp.user_id = u.id
                WHERE 1=1";
        $types = '';
        $params = [];

        if ($search !== '') {
            $sql .= " AND (u.nama LIKE ? OR u.email LIKE ?)";
            $like = "%{$search}%";
            $types .= 'ss';
            $params[] = $like;
            $params[] = $like;
        }

        if ($filter !== '') {
            $sql .= " AND fp.status = ?";
            $types .= 's';
            $params[] = $filter;
        }

        $sql .= " ORDER BY fp.created_at DESC";
        $fotos = $this->fetchAllAssoc($sql, $types, $params);

        $total = $this->db->query("SELECT COUNT(*) FROM foto_pengunjung")->fetch_row()[0] ?? 0;
        $pending = $this->db->query("SELECT COUNT(*) FROM foto_pengunjung WHERE status='pending'")->fetch_row()[0] ?? 0;
        $approved = $this->db->query("SELECT COUNT(*) FROM foto_pengunjung WHERE status='approved'")->fetch_row()[0] ?? 0;
        $rejected = $this->db->query("SELECT COUNT(*) FROM foto_pengunjung WHERE status='rejected'")->fetch_row()[0] ?? 0;

        require __DIR__ . '/../views/admin/foto_user.php';
    }
}
