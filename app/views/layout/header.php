<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Simbar' ?> - Simbar</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
</head>
<body>
    <?php $currentUrl = trim($_GET['url'] ?? '', '/'); ?>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon">📦</span>
                <span>SIMBAR</span>
            </div>
            <nav class="sidebar-nav">
                <a class="<?= $currentUrl === 'barang/dashboard' ? 'active' : '' ?>" href="<?= APP_URL ?>barang/dashboard">🏠 Dashboard</a>
                <a class="<?= $currentUrl === 'barang' || strpos($currentUrl, 'barang/edit') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>barang">📋 Data Barang</a>
                <a class="<?= strpos($currentUrl, 'barang/tambah') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>barang/tambah">➕ Tambah Barang</a>
                <a class="<?= strpos($currentUrl, 'transaksi') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>transaksi">🔄 Transaksi</a>
            </nav>
            <?php if (!empty($_SESSION['user'])): ?>
            <div class="sidebar-user">
                <span class="uname"><?= htmlspecialchars($_SESSION['user']['nama_lengkap'] ?? $_SESSION['user']['username'] ?? 'Pengguna') ?></span>
                <a class="logout-link" href="<?= APP_URL ?>logout">🚪 Keluar</a>
            </div>
            <?php endif; ?>
        </aside>
        <main class="content">
            <header class="topbar">
                <h1><?= $title ?? '' ?></h1>
            </header>
            <div class="content-body">

