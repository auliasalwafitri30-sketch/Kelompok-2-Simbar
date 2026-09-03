<?php
/**
 * TransaksiModel.php
 * Model untuk manajemen data transaksi barang
 */

class TransaksiModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Ambil semua transaksi
     */
    public function getAll(): array
    {
        $query = "SELECT t.*, b.kode_barang, b.nama_barang, 'pcs' AS satuan
                  FROM transaksi t 
                  LEFT JOIN barang b ON t.id_barang = b.id_barang 
                  ORDER BY t.tanggal DESC, t.id_transaksi DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ambil transaksi berdasarkan ID
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT t.*, b.kode_barang, b.nama_barang, 'pcs' AS satuan
                  FROM transaksi t 
                  LEFT JOIN barang b ON t.id_barang = b.id_barang 
                  WHERE t.id_transaksi = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tambah transaksi baru
     */
    public function create(array $data): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Insert transaksi
            $queryTransaksi = 'INSERT INTO transaksi (id_barang, jenis, jumlah, tanggal, keterangan) 
                               VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->db->prepare($queryTransaksi);
            
            $stmt->bindParam(1, $data['id_barang'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['jenis'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['jumlah'], PDO::PARAM_INT);
            $stmt->bindParam(4, $data['tanggal'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['keterangan'], PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal insert transaksi');
            }

            // 2. Update stok barang
            $jenis = strtolower($data['jenis'] ?? 'masuk');
            $operator = ($jenis === 'masuk') ? '+' : '-';
            
            $queryUpdate = "UPDATE barang SET stok = stok {$operator} ? WHERE id_barang = ?";
            $stmt = $this->db->prepare($queryUpdate);
            $stmt->bindParam(1, $data['jumlah'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['id_barang'], PDO::PARAM_INT);
            
            if (!$stmt->execute()) {
                throw new Exception('Gagal update stok');
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error create transaksi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Ambil transaksi berdasarkan barang
     */
    public function getByBarangId(int $barangId): array
    {
        $query = 'SELECT * FROM transaksi WHERE id_barang = ? ORDER BY tanggal DESC';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $barangId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Hitung total transaksi
     */
    public function countAll(): int
    {
        $query = 'SELECT COUNT(*) as total FROM transaksi';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return (int) ($row['total'] ?? 0);
    }

    /**
     * Ambil transaksi dalam periode tertentu
     */
    public function getByDateRange(string $startDate, string $endDate): array
    {
        $query = "SELECT t.*, b.kode_barang, b.nama_barang, 'pcs' AS satuan
                  FROM transaksi t 
                  LEFT JOIN barang b ON t.id_barang = b.id_barang 
                  WHERE DATE(t.tanggal) BETWEEN ? AND ? 
                  ORDER BY t.tanggal DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $startDate, PDO::PARAM_STR);
        $stmt->bindParam(2, $endDate, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
