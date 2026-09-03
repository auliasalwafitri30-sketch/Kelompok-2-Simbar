<?php
if (!defined('BASE_URL')) {
    header('Location: /Kelompok-2-Simbar/public/index.php?url=transaksi');
    exit;
}
?>

<div class="toolbar">
    <a href="<?= APP_URL ?>transaksi/tambah" class="btn btn-primary">+ Input Transaksi</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($transaksi)): ?>
            <tr><td colspan="6" class="text-center">Belum ada data transaksi.</td></tr>
        <?php else: ?>
            <?php foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['tanggal']) ?></td>
                    <td><?= htmlspecialchars($t['kode_barang'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($t['nama_barang'] ?? '-') ?></td>
                    <td>
                        <span class="badge <?= strtolower($t['jenis'] ?? '') === 'masuk' ? 'badge-success' : 'badge-danger' ?>">
                            <?= htmlspecialchars($t['jenis'] ?? '-') ?>
                        </span>
                    </td>
                    <td><?= $t['jumlah'] ?> <?= htmlspecialchars($t['satuan'] ?? 'pcs') ?></td>
                    <td><?= htmlspecialchars($t['keterangan'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>