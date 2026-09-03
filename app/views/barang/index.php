<?php
if (!defined('BASE_URL')) {
    header('Location: /Kelompok-2-Simbar/public/index.php?url=barang');
    exit;
}
?>

<div class="toolbar">
    <form method="get" class="search-form">
        <input type="text" name="q" placeholder="Cari kode atau nama barang..." value="<?= htmlspecialchars($keyword ?? '') ?>">
        <button type="submit">Cari</button>
    </form>
    <a href="<?= APP_URL ?>barang/tambah" class="btn btn-primary">+ Tambah Barang</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Satuan</th>
            <th>Harga Jual</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($barang)): ?>
            <tr><td colspan="8" class="text-center">Belum ada data barang.</td></tr>
        <?php else: ?>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($b['kategori'] ?? '-') ?></td>
                    <td>
                        <span class="badge <?= $b['stok'] <= $b['stok_minimum'] ? 'badge-danger' : 'badge-success' ?>">
                            <?= (int) $b['stok'] ?>
                        </span>
                    </td>
                    <td>pcs</td>
                    <td>Rp <?= number_format((float) $b['harga_jual'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($b['lokasi_rak'] ?? '-') ?></td>
                    <td class="actions">
                        <a href="<?= APP_URL ?>barang/edit/<?= $b['id_barang'] ?>">Edit</a>
                        <a href="<?= APP_URL ?>barang/hapus/<?= $b['id_barang'] ?>"
                           onclick="return confirm('Hapus barang ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
