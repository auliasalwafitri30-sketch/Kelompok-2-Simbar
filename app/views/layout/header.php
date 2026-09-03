<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Simbar' ?> - Simbar</title>
    <?php $baseUrl = BASE_URL !== '' ? rtrim(BASE_URL, '/') : rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/'); ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>/assets/css/style.css">
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
                    <a class="<?= $currentUrl === 'barang/dashboard' ? 'active' : '' ?>" href="<?= $baseUrl ?>/index.php?url=barang/dashboard">🏠 Dashboard</a>
                    <a class="<?= $currentUrl === 'barang' || strpos($currentUrl, 'barang/edit') === 0 ? 'active' : '' ?>" href="<?= $baseUrl ?>/index.php?url=barang">📋 Data Barang</a>
                    <a class="<?= strpos($currentUrl, 'barang/tambah') === 0 ? 'active' : '' ?>" href="<?= $baseUrl ?>/index.php?url=barang/tambah">➕ Tambah Barang</a>
                    <a class="<?= strpos($currentUrl, 'transaksi') === 0 ? 'active' : '' ?>" href="<?= $baseUrl ?>/index.php?url=transaksi">🔄 Transaksi</a>
            </nav>
            <?php if (!empty($_SESSION['user'])): ?>
            <div class="sidebar-user">
                    <span class="uname"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                    <a class="logout-link" href="<?= $baseUrl ?>/index.php?url=logout">Keluar</a>
            </div>
            <?php endif; ?>
        </aside>
        <main class="content">
            <header class="topbar">
                <h1><?= $title ?? '' ?></h1>
            </header>
            <div class="content-body">

