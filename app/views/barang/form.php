<?php $isEdit = isset($barang); ?>

<form method="post" class="form-card">
    <?php if (!$isEdit): ?>
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" required placeholder="Contoh: BRG-0004">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required
               value="<?= htmlspecialchars($barang['nama_barang'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori_id">
            <option value="">- Pilih Kategori -</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id'] ?>"
                    <?= (isset($barang) && $barang['kategori_id'] == $k['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Satuan</label>
            <input type="text" name="satuan" value="<?= htmlspecialchars($barang['satuan'] ?? 'pcs') ?>">
        </div>

        <?php if (!$isEdit): ?>
        <div class="form-group">
            <label>Stok Awal</label>
            <input type="number" name="stok" min="0" value="0">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Stok Minimum</label>
            <input type="number" name="stok_minimum" min="0"
                   value="<?= htmlspecialchars($barang['stok_minimum'] ?? 5) ?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli"
                   value="<?= htmlspecialchars($barang['harga_beli'] ?? 0) ?>">
        </div>
        <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" step="0.01" name="harga_jual"
                   value="<?= htmlspecialchars($barang['harga_jual'] ?? 0) ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Lokasi</label>
        <input type="text" name="lokasi_rak" value="<?= htmlspecialchars($barang['lokasi_rak'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" rows="3"><?= htmlspecialchars($barang['keterangan'] ?? '') ?></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Barang' ?></button>
        <a href="<?= APP_URL ?>barang" class="btn btn-secondary">Batal</a>
    </div>
</form>
