<?php
if (!defined('BASE_URL')) {
    header('Location: /Kelompok-2-Simbar/public/index.php?url=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simbar</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
</head>
<body>
    <div id="loginScreen">
        <div class="login-card">
            <div class="login-brand">📦 SIMBAR</div>
            <div class="login-sub">Sistem Informasi Manajemen Barang</div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= APP_URL ?>login">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="admin" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="admin123" required>
                </div>
                <button type="submit" class="login-btn">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
<<<<<<< HEAD
                </div>

tes
=======
>>>>>>> 85a4494db33a751a0dc3b91d8f75c74f7953a4f4
