<?php
/**
 * BarangModel.php
 * Model untuk manajemen data barang
 */

class BarangModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Ambil semua barang dengan pencarian opsional
     */
    public function getAll(string $keyword = ''): array
    {
        $query = 'SELECT * FROM barang WHERE 1=1';
        
        if (!empty($keyword)) {
            $query .= " AND (kode_barang LIKE ? OR nama_barang LIKE ?)";
        }
        
        $query .= ' ORDER BY id_barang DESC';
        
        $stmt = $this->db->prepare($query);
        
        if (!empty($keyword)) {
            $searchTerm = "%{$keyword}%";
            $stmt->bindParam(1, $searchTerm, PDO::PARAM_STR);
            $stmt->bindParam(2, $searchTerm, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ambil barang berdasarkan ID
     */
    public function getById(int $id): ?array
    {
        $query = 'SELECT * FROM barang WHERE id_barang = ?';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Hitung total barang
     */
    public function countAll(): int
    {
        $query = 'SELECT COUNT(*) as total FROM barang';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return (int) ($row['total'] ?? 0);
    }

    /**
     * Ambil barang dengan stok menipis
     */
    public function getStokMenipis(): array
    {
        $query = 'SELECT * FROM barang WHERE stok <= stok_minimum ORDER BY stok ASC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Tambah barang baru
     */
    public function create(array $data): bool
    {
        try {
            $query = 'INSERT INTO barang 
                      (kode_barang, nama_barang, stok, kategori, harga_beli, harga_jual, lokasi_rak, stok_minimum, keterangan, kondisi) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            
            $stmt = $this->db->prepare($query);
            
            $kondisi = 'baik';
            $stmt->bindParam(1, $data['kode_barang'], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['nama_barang'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['stok'], PDO::PARAM_INT);
            $kategoriId = $data['kategori_id'] ?? 0;
            $stmt->bindValue(4, $kategoriId, PDO::PARAM_INT);
            $stmt->bindParam(5, $data['harga_beli'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['harga_jual'], PDO::PARAM_STR);
            $stmt->bindParam(7, $data['lokasi_rak'], PDO::PARAM_STR);
            $stmt->bindParam(8, $data['stok_minimum'], PDO::PARAM_INT);
            $stmt->bindParam(9, $data['keterangan'], PDO::PARAM_STR);
            $stmt->bindParam(10, $kondisi, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error create barang: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update barang
     */
    public function update(int $id, array $data): bool
    {
        try {
            $query = 'UPDATE barang SET 
                      nama_barang = ?, 
                      kategori = ?, 
                      harga_beli = ?, 
                      harga_jual = ?, 
                      lokasi_rak = ?, 
                      stok_minimum = ?, 
                      keterangan = ? 
                      WHERE id_barang = ?';
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(1, $data['nama_barang'], PDO::PARAM_STR);
            $kategoriId = $data['kategori_id'] ?? 0;
            $stmt->bindValue(2, $kategoriId, PDO::PARAM_INT);
            $stmt->bindParam(3, $data['harga_beli'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['harga_jual'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['lokasi_rak'], PDO::PARAM_STR);
            $stmt->bindParam(6, $data['stok_minimum'], PDO::PARAM_INT);
            $stmt->bindParam(7, $data['keterangan'], PDO::PARAM_STR);
            $stmt->bindParam(8, $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error update barang: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Hapus barang
     */
    public function delete(int $id): bool
    {
        try {
            $query = 'DELETE FROM barang WHERE id_barang = ?';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log('Error delete barang: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Ambil semua kategori
     */
    public function getAllKategori(): array
    {
        $query = 'SELECT * FROM kategori ORDER BY nama_kategori ASC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}