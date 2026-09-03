<form method="post" class="form-card">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-group">
        <label>Jenis Transaksi</label>
        <select name="jenis" required>
            <option value="">- Pilih Jenis -</option>
            <option value="masuk">Barang Masuk</option>
            <option value="keluar">Barang Keluar</option>
        </select>
    </div>

    <div class="form-group">
        <label>Barang</label>
        <select name="barang_id" required>
            <option value="">- Pilih Barang -</option>
            <?php foreach ($barang as $b): ?>
                <option value="<?= $b['id_barang'] ?>">
                    <?= htmlspecialchars($b['kode_barang']) ?> - <?= htmlspecialchars($b['nama_barang']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required value="<?= date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <input type="number" name="jumlah" min="1" value="1" required>
        </div>
    </div>

    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        <a href="<?= APP_URL ?>transaksi" class="btn btn-secondary">Batal</a>
    </div>
</form>