<?php

class UlasanModel
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $result = $this->db->query("SELECT * FROM ulasan ORDER BY created_at DESC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getApproved(int $limit = 6): array
    {
        $stmt = $this->db->prepare("SELECT * FROM ulasan WHERE status='approved' ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function getAvgRating(): float
    {
        $res = $this->db->query("SELECT AVG(rating) as avg FROM ulasan WHERE status='approved'");
        $row = $res ? $res->fetch_assoc() : null;
        return $row ? round((float)$row['avg'], 1) : 0.0;
    }

    public function countApproved(): int
    {
        $res = $this->db->query("SELECT COUNT(*) as n FROM ulasan WHERE status='approved'");
        $row = $res ? $res->fetch_assoc() : null;
        return $row ? (int)$row['n'] : 0;
    }

    public function getByWahana(string $wahanaName, int $limit = 10): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM ulasan WHERE status='approved' AND wahana_name=? ORDER BY created_at DESC LIMIT ?"
        );
        $stmt->bind_param("si", $wahanaName, $limit);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function getAvgRatingByWahana(string $wahanaName): float
    {
        $stmt = $this->db->prepare("SELECT AVG(rating) as avg FROM ulasan WHERE status='approved' AND wahana_name=?");
        $stmt->bind_param("s", $wahanaName);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row ? round((float)$row['avg'], 1) : 0.0;
    }

    public function create(string $namaPengunjung, string $ulasan, int $rating): bool
    {
        $stmt = $this->db->prepare("INSERT INTO ulasan (nama_user, ulasan, rating, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("ssi", $namaPengunjung, $ulasan, $rating);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function createWithWahana(string $namaPengunjung, string $ulasan, int $rating, string $wahanaName, ?int $userId = null): bool
    {

        $cols = $this->db->query("SHOW COLUMNS FROM ulasan LIKE 'wahana_name'");
        if ($cols && $cols->num_rows === 0) {
            $this->db->query("ALTER TABLE ulasan ADD COLUMN wahana_name VARCHAR(200) DEFAULT NULL");
        }

        $colsUid = $this->db->query("SHOW COLUMNS FROM ulasan LIKE 'user_id'");
        if ($colsUid && $colsUid->num_rows === 0) {
            $this->db->query("ALTER TABLE ulasan ADD COLUMN user_id INT DEFAULT NULL");
        }
        $stmt = $this->db->prepare("INSERT INTO ulasan (nama_user, ulasan, rating, status, wahana_name, user_id) VALUES (?, ?, ?, 'pending', ?, ?)");
        $stmt->bind_param("ssisi", $namaPengunjung, $ulasan, $rating, $wahanaName, $userId);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE ulasan SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM ulasan WHERE id = ?");
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }


    public function countTodayByUserId(int $userId): int
    {

        $colsUid = $this->db->query("SHOW COLUMNS FROM ulasan LIKE 'user_id'");
        if (!$colsUid || $colsUid->num_rows === 0) {
            return 0;
        }
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as n FROM ulasan WHERE user_id = ? AND DATE(created_at) = CURDATE()"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return (int)($row['n'] ?? 0);
    }


    public function countTodayByUser(string $namaUser): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as n FROM ulasan WHERE nama_user = ? AND DATE(created_at) = CURDATE()"
        );
        $stmt->bind_param("s", $namaUser);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return (int)($row['n'] ?? 0);
    }
}
