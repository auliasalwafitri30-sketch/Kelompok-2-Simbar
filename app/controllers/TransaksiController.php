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
            $jumlah = (int) $_POST['jumlah'];
            $barang = $this->barangModel->getById((int) $_POST['barang_id']);

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

            $this->transaksiModel->create([
                'id_barang'   => $_POST['barang_id'],
                'jumlah'      => $jumlah,
                'tanggal'     => $_POST['tanggal'],
                'keterangan'  => $_POST['keterangan'],
            ]);
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

