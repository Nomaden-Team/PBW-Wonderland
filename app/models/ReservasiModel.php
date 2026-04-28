<?php

class ReservasiModel
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function getAll(string $search = '', string $filterStatus = ''): array
    {
        $where  = "WHERE 1=1";
        $params = [];
        $types  = '';

        if ($search) {
            $where   .= " AND (nama_kegiatan LIKE ? OR jenis_kegiatan LIKE ?)";
            $s        = "%$search%";
            $params[] = $s;
            $params[] = $s;
            $types   .= 'ss';
        }

        if ($filterStatus) {
            $where   .= " AND status = ?";
            $params[] = $filterStatus;
            $types   .= 's';
        }

        $sql = "SELECT * FROM reservasi $where ORDER BY created_at DESC";

        if (empty($params)) {
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM reservasi WHERE user_id = ? ORDER BY created_at DESC"
        );
        if (!$stmt) return [];
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows   = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $rows;
    }

    public function createByUser(int $userId, string $namaKegiatan, string $tanggal, int $jumlahPeserta, string $keterangan = ''): string
    {

        $check = $this->db->query("SHOW COLUMNS FROM reservasi LIKE 'kode_booking'");
        if ($check && $check->num_rows === 0) {
            $this->db->query("ALTER TABLE reservasi ADD COLUMN kode_booking VARCHAR(20) DEFAULT NULL");
        }

        $kodeBooking = strtoupper(substr(md5(uniqid($userId . time(), true)), 0, 10));
        $status = 'terjadwal';
        $stmt = $this->db->prepare(
            "INSERT INTO reservasi (user_id, nama_kegiatan, tanggal, jumlah_peserta, keterangan, status, kode_booking, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param("ississs", $userId, $namaKegiatan, $tanggal, $jumlahPeserta, $keterangan, $status, $kodeBooking);
        $stmt->execute();
        $stmt->close();
        return $kodeBooking;
    }

    public function create(int $userId, int $wahanaId, string $tanggal, int $jumlah): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO reservasi (user_id, wahana_id, tanggal, jumlah_tiket, status, created_at)
             VALUES (?, ?, ?, ?, 'pending', NOW())"
        );
        $stmt->bind_param("iisd", $userId, $wahanaId, $tanggal, $jumlah);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE reservasi SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM reservasi WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
