<div class="stat-cards">
    <div class="stat-card">
        <span class="stat-number"><?= $totalBarang ?></span>
        <span class="stat-label">Total Jenis Barang</span>
    </div>
    <div class="stat-card stat-warning">
        <span class="stat-number"><?= count($stokMenipis) ?></span>
        <span class="stat-label">Barang Stok Menipis</span>
    </div>
</div>

<h2>⚠️ Peringatan Stok Menipis</h2>
<table class="table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Stok Minimum</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($stokMenipis)): ?>
            <tr><td colspan="4" class="text-center">Tidak ada stok yang menipis.</td></tr>
        <?php else: ?>
            <?php foreach ($stokMenipis as $b): ?>
                <tr>
                    <td><?= htmlspecialchars($b['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                    <td><span class="badge badge-danger"><?= $b['stok'] ?></span></td>
                    <td><?= $b['stok_minimum'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
