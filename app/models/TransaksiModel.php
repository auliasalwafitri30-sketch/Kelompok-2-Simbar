<?php
/**
 * TransaksiModel.php
<<<<<<< HEAD
 * Model untuk manajemen data transaksi barang
=======
 * Model untuk mengelola transaksi barang masuk & keluar
>>>>>>> 1567ffb (user model done)
 */

class TransaksiModel
{
    private $db;
<<<<<<< HEAD

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
=======
    private $table = 'transaksi';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $sql = "SELECT t.*, b.nama_barang, b.kode_barang
                FROM {$this->table} t
                JOIN barang b ON t.id_barang = b.id
                ORDER BY t.tanggal DESC, t.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getByBarang(int $barangId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id_barang = :id ORDER BY tanggal DESC"
        );
        $stmt->execute([':id' => $barangId]);
>>>>>>> 1567ffb (user model done)
        return $stmt->fetchAll();
    }

    /**
<<<<<<< HEAD
     * Ambil transaksi berdasarkan ID
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT t.*, b.kode_barang, b.nama_barang, 'pcs' AS satuan
                  FROM transaksi t 
                  LEFT JOIN barang b ON t.id_barang = b.id_barang 
                  WHERE t.id_transaksi = ?";<?php
/**
 * TransaksiModel.php
 * Model untuk manajemen transaksi barang masuk & keluar
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
        $query = "SELECT t.*, 
                         b.kode_barang, 
                         b.nama_barang, 
                         'pcs' AS satuan
                  FROM transaksi t
                  LEFT JOIN barang b 
                    ON t.id_barang = b.id_barang
                  ORDER BY t.tanggal DESC, 
                           t.id_transaksi DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Ambil transaksi berdasarkan ID
     */
    public function getById(int $id): ?array
    {
        $query = "SELECT t.*, 
                         b.kode_barang, 
                         b.nama_barang, 
                         'pcs' AS satuan
                  FROM transaksi t
                  LEFT JOIN barang b 
                    ON t.id_barang = b.id_barang
                  WHERE t.id_transaksi = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * Ambil transaksi berdasarkan barang
     */
    public function getByBarang(int $barangId): array
    {
        $query = "SELECT *
                  FROM transaksi
                  WHERE id_barang = ?
                  ORDER BY tanggal DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $barangId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Alias untuk getByBarang()
     */
    public function getByBarangId(int $barangId): array
    {
        return $this->getByBarang($barangId);
    }

    /**
     * Tambah transaksi baru
     * Sekaligus memperbarui stok barang.
     */
    public function create(array $data): bool
    {
        try {
            $this->db->beginTransaction();

            // 1. Insert transaksi
            $queryTransaksi = 'INSERT INTO transaksi
                              (
                                  id_barang,
                                  jenis,
                                  jumlah,
                                  tanggal,
                                  keterangan
                              )
                              VALUES (?, ?, ?, ?, ?)';

            $stmt = $this->db->prepare($queryTransaksi);

            $stmt->bindParam(
                1,
                $data['barang_id'],
                PDO::PARAM_INT
            );

            $stmt->bindParam(
                2,
                $data['jenis'],
                PDO::PARAM_STR
            );

            $stmt->bindParam(
                3,
                $data['jumlah'],
                PDO::PARAM_INT
            );

            $stmt->bindParam(
                4,
                $data['tanggal'],
                PDO::PARAM_STR
            );

            $keterangan = $data['keterangan'] ?? null;

            $stmt->bindValue(
                5,
                $keterangan,
                $keterangan === null
                    ? PDO::PARAM_NULL
                    : PDO::PARAM_STR
            );

            if (!$stmt->execute()) {
                throw new Exception(
                    'Gagal insert transaksi'
                );
            }

            // 2. Update stok barang
            $jenis = strtolower(
                $data['jenis'] ?? 'masuk'
            );

            $operator = ($jenis === 'masuk')
                ? '+'
                : '-';

            $queryUpdate = "UPDATE barang
                            SET stok = stok {$operator} ?
                            WHERE id_barang = ?";

            $stmt = $this->db->prepare($queryUpdate);

            $stmt->bindParam(
                1,
                $data['jumlah'],
                PDO::PARAM_INT
            );

            $stmt->bindParam(
                2,
                $data['barang_id'],
                PDO::PARAM_INT
            );

            if (!$stmt->execute()) {
                throw new Exception(
                    'Gagal update stok'
                );
            }

            $this->db->commit();

            return true;

        } catch (Exception $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            error_log(
                'Error create transaksi: '
                . $e->getMessage()
            );

            return false;
        }
    }

    /**
     * Hitung total transaksi
     */
    public function countAll(): int
    {
        $query = 'SELECT COUNT(*) AS total
                  FROM transaksi';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch();

        return (int) ($row['total'] ?? 0);
    }

    /**
     * Ambil transaksi dalam periode tertentu
     */
    public function getByDateRange(
        string $startDate,
        string $endDate
    ): array {
        $query = "SELECT t.*, 
                         b.kode_barang, 
                         b.nama_barang, 
                         'pcs' AS satuan
                  FROM transaksi t
                  LEFT JOIN barang b
                    ON t.id_barang = b.id_barang
                  WHERE DATE(t.tanggal) 
                        BETWEEN ? AND ?
                  ORDER BY t.tanggal DESC";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(
            1,
            $startDate,
            PDO::PARAM_STR
        );

        $stmt->bindParam(
            2,
            $endDate,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Rekap transaksi bulanan
     *
     * Format $bulan: YYYY-MM
     */
    public function getRekapBulanan(
        string $bulan
    ): array {
        $query = "SELECT jenis,
                         SUM(jumlah) AS total
                  FROM transaksi
                  WHERE DATE_FORMAT(
                      tanggal,
                      '%Y-%m'
                  ) = ?
                  GROUP BY jenis";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(
            1,
            $bulan,
            PDO::PARAM_STR
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
?>
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tambah transaksi baru
=======
     * Catat transaksi baru dan sekaligus perbarui stok barang.
     * Menggunakan transaction DB agar data tetap konsisten.
>>>>>>> 1567ffb (user model done)
     */
    public function create(array $data): bool
    {
        try {
            $this->db->beginTransaction();

<<<<<<< HEAD
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
=======
            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table} (id_barang, jenis, jumlah, tanggal, keterangan)
                 VALUES (:id_barang, :jenis, :jumlah, :tanggal, :keterangan)"
            );
            $stmt->execute([
                ':id_transaksi'   => $data['barang_id'],
                ':id_barang'      => $data['jenis'],
                ':jumlah'         => $data['jumlah'],
                ':tanggal'        => $data['tanggal'],
                ':keterangan'     => $data['keterangan'] ?? null,
            ]);

            $operator = ($data['jenis'] === 'masuk') ? '+' : '-';
            $stmtStok = $this->db->prepare(
                "UPDATE barang SET stok = stok {$operator} :jumlah WHERE id = :id_barang"
            );
            $stmtStok->execute([
                ':jumlah'    => $data['jumlah'],
                ':id_barang' => $data['id_barang'],
            ]);
>>>>>>> 1567ffb (user model done)

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
<<<<<<< HEAD
            error_log('Error create transaksi: ' . $e->getMessage());
=======
>>>>>>> 1567ffb (user model done)
            return false;
        }
    }

<<<<<<< HEAD
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
=======
    public function getRekapBulanan(string $bulan): array
    {
        // $bulan format: 'YYYY-MM'
        $sql = "SELECT jenis, SUM(jumlah) AS total
                FROM {$this->table}
                WHERE DATE_FORMAT(tanggal, '%Y-%m') = :bulan
                GROUP BY jenis";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':bulan' => $bulan]);
        return $stmt->fetchAll();
    }
}
?>
>>>>>>> 1567ffb (user model done)
