<?php
/**
 * BarangController.php
 * Mengatur tampilan & aksi CRUD untuk data barang
 */

class BarangController extends Controller
{
    private $barangModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->barangModel = $this->model('BarangModel');
    }

    /** Halaman daftar barang: /barang */
    public function index(): void
    {
        $keyword = $_GET['q'] ?? '';
        $data = [
            'title'  => 'Data Barang',
            'barang' => $this->barangModel->getAll($keyword),
            'keyword'=> $keyword,
        ];
        $this->view('barang/index', $data);
    }

    /** Form tambah barang: /barang/tambah */
    public function tambah(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->barangModel->create([
                 'nama_barang'  => trim($_POST['nama_barang'] ?? ''),
                'kategori_id'  => !empty($_POST['kategori_id']) ? (int) $_POST['kategori_id'] : 0,
                 'kode_barang'  => trim($_POST['kode_barang'] ?? ''),
                'stok'       => (int) $_POST['stok'],
                'stok_minimum' => (int) $_POST['stok_minimum'],
                'harga_beli'   => (int) $_POST['harga_beli'],
                'harga_jual'   => (int) $_POST['harga_jual'],
                'lokasi_rak'   => $_POST['lokasi_rak'],
                'keterangan'   => $_POST['keterangan'],
            ]);
            $this->redirect('barang');
            return;
        }

        $data = [
            'title'    => 'Tambah Barang',
            'kategori' => $this->barangModel->getAllKategori(),
        ];
        $this->view('barang/form', $data);
    }

    /** Form edit barang: /barang/edit/{id} */
    public function edit(int $id): void
    {
        $barang = $this->barangModel->getById($id);
        if (!$barang) {
            $this->redirect('barang');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->barangModel->update($id, [
                'nama_barang'  => $_POST['nama_barang'],
                'kategori_id'  => !empty($_POST['kategori_id']) ? (int) $_POST['kategori_id'] : 0,
                'stok'       => (int) $_POST['stok'],
                'stok_minimum' => (int) $_POST['stok_minimum'],
                'harga_beli'   => (int) $_POST['harga_beli'],
                'harga_jual'   => (int) $_POST['harga_jual'],
                'lokasi_rak'   => $_POST['lokasi_rak'],
                'keterangan'   => $_POST['keterangan'],
            ]);
            $this->redirect('barang');
            return;
        }

        $data = [
            'title'    => 'Edit Barang',
            'barang'   => $barang,
            'kategori' => $this->barangModel->getAllKategori(),
        ];
        $this->view('barang/form', $data);
    }

    /** Hapus barang: /barang/hapus/{id} */
    public function hapus(int $id): void
    {
        $this->barangModel->delete($id);
        $this->redirect('barang');
    }

    /** Dashboard ringkas: /barang/dashboard */
    public function dashboard(): void
    {
        $data = [
            'title'        => 'Dashboard Inventaris',
            'totalBarang'  => $this->barangModel->countAll(),
            'stokMenipis'  => $this->barangModel->getStokMenipis(),
        ];
        $this->view('barang/dashboard', $data);
    }
}
