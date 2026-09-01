<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Simbar' ?> - Simbar</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon">📦</span>
                <span>SIMBAR</span>
            </div>
            <nav class="sidebar-nav">
                <a href="<?= BASE_URL ?>/barang/dashboard">🏠 Dashboard</a>
                <a href="<?= BASE_URL ?>/barang">📋 Data Barang</a>
                <a href="<?= BASE_URL ?>/transaksi">🔄 Transaksi</a>
                <a href="<?= BASE_URL ?>/transaksi/tambah">➕ Input Transaksi</a>
            </nav>
            <?php if (!empty($_SESSION['user'])): ?>
            <div class="sidebar-user">
                <span class="uname"><?= htmlspecialchars($_SESSION['user']['nama_lengkap']) ?></span>
                <a class="logout-link" href="<?= BASE_URL ?>/logout">🚪 Keluar</a>
            </div>
            <?php endif; ?>
        </aside>
        <main class="content">
            <header class="topbar">
                <h1><?= $title ?? '' ?></h1>
            </header>
            <div class="content-body">

