<?php
/**
 * setup.php - Setup aplikasi & create test user
 * JANGAN DEPLOY KE PRODUCTION!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('APP_PATH', dirname(__DIR__) . '/app');
require_once APP_PATH . '/config/Database.php';

$message = '';
$error = '';

// Jika user klik tombol setup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup'])) {
    try {
        $database = new Database();
        $db = $database->connect();

        // Hash password membutuhkan kolom teks, bukan INT.
        $db->exec('ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL');
        $db->exec('ALTER TABLE kategori MODIFY nama_kategori VARCHAR(100) NOT NULL');

        $kategoriCount = (int) $db->query('SELECT COUNT(*) FROM kategori')->fetchColumn();
        if ($kategoriCount === 0) {
            $stmt = $db->prepare('INSERT INTO kategori (nama_kategori) VALUES (?), (?), (?), (?)');
            $stmt->execute([
                'Alat Tulis Kantor',
                'Elektronik',
                'Peralatan Kebersihan',
                'Furniture',
            ]);
        }

        $jenisColumn = $db->query("SHOW COLUMNS FROM transaksi LIKE 'jenis'")->fetch();
        if (!$jenisColumn) {
            $db->exec("ALTER TABLE transaksi ADD jenis ENUM('masuk', 'keluar') NOT NULL DEFAULT 'masuk' AFTER id_barang");
        }

        // Check apakah user admin sudah ada
        $stmt = $db->prepare('SELECT COUNT(*) as count FROM users WHERE username = ?');
        $stmt->execute(['admin']);
        $row = $stmt->fetch();

        if ($row['count'] > 0) {
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare('UPDATE users SET password = ?, role = ? WHERE username = ?');
            $stmt->execute([$hashedPassword, 'admin', 'admin']);
            $message = '✅ Password user admin berhasil diperbaiki. Username: admin, Password: admin123';
        } else {
            // Insert user admin
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
            $stmt->execute(['admin', $hashedPassword, 'admin']);
            $message = '✅ User admin berhasil dibuat! Username: admin, Password: admin123';
        }
    } catch (Exception $e) {
        $error = '❌ Error: ' . $e->getMessage();
    }
}

// Check database connection
try {
    $database = new Database();
    $db = $database->connect();
    $db_status = '✅ Database Connected';
    $db_class = 'success';
} catch (Exception $e) {
    $db_status = '❌ Database Error: ' . $e->getMessage();
    $db_class = 'danger';
}

// Count users
try {
    $stmt = $db->prepare('SELECT COUNT(*) as count FROM users');
    $stmt->execute();
    $row = $stmt->fetch();
    $user_count = $row['count'] ?? 0;
} catch (Exception $e) {
    $user_count = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Simbar</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
            padding: 40px;
        }
        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        .status-box {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .status-box.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .status-box.danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .info-box {
            background: #f0f9ff;
            border: 1px solid #7dd3fc;
            color: #0c4a6e;
            padding: 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #374151;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #5568d3;
        }
        .message {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .message.success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .message.danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .next-steps {
            background: #f9fafb;
            padding: 16px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .next-steps h3 {
            font-size: 0.95rem;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .next-steps ol {
            margin-left: 20px;
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.8;
        }
        .next-steps a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .next-steps a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Setup SIMBAR</h1>
        <p class="subtitle">Konfigurasi awal aplikasi</p>

        <!-- Database Status -->
        <div class="status-box <?= $db_class ?>">
            <?= $db_status ?>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message success"><?= $message ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="message danger"><?= $error ?></div>
        <?php endif; ?>

        <div class="info-box">
            📊 User di Database: <strong><?= $user_count ?> user</strong>
        </div>

        <!-- Setup Form -->
        <form method="post">
            <div class="form-group">
                <label>📋 Status Database</label>
                <input type="text" readonly value="<?= $db_status ?>" style="background: #f3f4f6; cursor: not-allowed;">
            </div>

            <button type="submit" name="setup" class="btn" 
                    <?= $db_class === 'danger' ? 'disabled' : '' ?>>
                Buat User Test (admin/admin123)
            </button>
        </form>

        <!-- Next Steps -->
        <div class="next-steps">
            <h3>📝 Langkah Selanjutnya:</h3>
            <ol>
                <li>Klik tombol "Buat User Test" untuk membuat akun admin</li>
                <li>Akses aplikasi: <a href="<?= dirname($_SERVER['REQUEST_URI']) ?>/login" target="_blank">/login</a></li>
                <li>Login dengan username: <strong>admin</strong>, password: <strong>admin123</strong></li>
                <li>Navigasi ke <strong>Data Barang</strong> untuk melihat daftar barang</li>
            </ol>
        </div>
    </div>
</body>
</html>
