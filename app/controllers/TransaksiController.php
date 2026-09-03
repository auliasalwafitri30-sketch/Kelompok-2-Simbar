<?php
/**
 * TransaksiController.php
 * Mengatur transaksi barang masuk & keluar
 */

class TransaksiController extends Controller
{
    private $transaksiModel;
    private $barangModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->transaksiModel = $this->model('TransaksiModel');
        $this->barangModel    = $this->model('BarangModel');
    }

    /** Riwayat transaksi: /transaksi */
    public function index(): void
    {
        $data = [
            'title'     => 'Riwayat Transaksi',
            'transaksi' => $this->transaksiModel->getAll(),
        ];
        $this->view('transaksi/index', $data);
    }

    /** Form input transaksi baru: /transaksi/tambah */
    public function tambah(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jenis = strtolower($_POST['jenis'] ?? 'masuk');
            $jumlah = (int) $_POST['jumlah'];
            $barang = $this->barangModel->getById((int) $_POST['barang_id']);

            if (!in_array($jenis, ['masuk', 'keluar'], true) || !$barang || $jumlah < 1) {
                $data = [
                    'title'  => 'Tambah Transaksi',
                    'barang' => $this->barangModel->getAll(),
                    'error'  => 'Data transaksi tidak valid. Pilih jenis, barang, dan jumlah yang benar.',
                ];
                $this->view('transaksi/form', $data);
                return;
            }

            // Validasi stok cukup untuk transaksi keluar
            if ($jenis === 'keluar' && $barang && $jumlah > $barang['stok']) {
                $data = [
                    'title'  => 'Tambah Transaksi',
                    'barang' => $this->barangModel->getAll(),
                    'error'  => 'Stok tidak mencukupi. Stok tersedia: ' . $barang['stok'],
                ];
                $this->view('transaksi/form', $data);
                return;
            }

            $saved = $this->transaksiModel->create([
                'id_barang'   => $_POST['barang_id'],
                'jumlah'      => $jumlah,
                'jenis'       => $jenis,
                'tanggal'     => $_POST['tanggal'],
                'keterangan'  => $_POST['keterangan'],
            ]);

            if (!$saved) {
                $data = [
                    'title'  => 'Tambah Transaksi',
                    'barang' => $this->barangModel->getAll(),
                    'error'  => 'Transaksi gagal disimpan. Periksa struktur database.',
                ];
                $this->view('transaksi/form', $data);
                return;
            }
            $this->redirect('transaksi');
            return;
        }

        $data = [
            'title'  => 'Tambah Transaksi',
            'barang' => $this->barangModel->getAll(),
        ];
        $this->view('transaksi/form', $data);
    }
}

