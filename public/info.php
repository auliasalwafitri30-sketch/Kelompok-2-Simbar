<?php
/**
 * info.php - Informasi tentang aplikasi dan cara akses yang benar
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Simbar</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            background: #f3f4f6;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        h1 {
            font-size: 2.2rem;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 1.4rem;
            color: #2563eb;
            margin-bottom: 16px;
            margin-top: 20px;
        }
        h2:first-child {
            margin-top: 0;
        }
        p {
            color: #4b5563;
            line-height: 1.8;
            margin-bottom: 12px;
        }
        code {
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #c7254e;
            font-weight: 600;
        }
        .url-example {
            background: #f8fafc;
            border-left: 4px solid #2563eb;
            padding: 16px;
            margin: 12px 0;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            color: #1f2937;
            overflow-x: auto;
        }
        .url-example.wrong {
            border-left-color: #dc2626;
            background: #fef2f2;
        }
        .url-example.correct {
            border-left-color: #16a34a;
            background: #f0fdf4;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        .badge-wrong {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-correct {
            background: #dcfce7;
            color: #166534;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        th, td {
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #f9fafb;
            font-weight: 600;
            color: #1f2937;
        }
        tr:last-child td {
            border-bottom: none;
        }
        ul, ol {
            margin-left: 24px;
            color: #4b5563;
            line-height: 2;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
            margin-top: 12px;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-warning {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #92400e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 SIMBAR - Sistem Informasi Manajemen Barang</h1>

        <div class="alert alert-warning">
            <strong>⚠️ Penting:</strong> URL yang Anda akses harus melalui routing PHP, bukan direct file access!
        </div>

        <div class="card">
            <h2>❌ URL yang SALAH (Jangan Gunakan)</h2>
            <p>Akses langsung ke folder views tidak akan berfungsi:</p>
            <div class="url-example wrong">
                <span class="badge badge-wrong">SALAH</span>
                http://localhost/Kelompok-2-Simbar/app/views/barang/
            </div>
            <p><strong>Alasan:</strong> View file tidak bisa diakses langsung - database tidak di-query, CSS tidak ter-load, session tidak dicek.</p>
        </div>

        <div class="card">
            <h2>✅ URL yang BENAR (Gunakan Ini)</h2>
            <p>Akses aplikasi melalui routing yang benar:</p>
            
            <h3 style="color: #1f2937; font-size: 1.1rem; margin-top: 16px;">1. Halaman Login</h3>
            <div class="url-example correct">
                <span class="badge badge-correct">BENAR</span>
                http://localhost/Kelompok-2-Simbar/login
            </div>

            <h3 style="color: #1f2937; font-size: 1.1rem; margin-top: 16px;">2. Halaman Dashboard</h3>
            <div class="url-example correct">
                <span class="badge badge-correct">BENAR</span>
                http://localhost/Kelompok-2-Simbar/barang/dashboard
            </div>

            <h3 style="color: #1f2937; font-size: 1.1rem; margin-top: 16px;">3. Halaman Data Barang</h3>
            <div class="url-example correct">
                <span class="badge badge-correct">BENAR</span>
                http://localhost/Kelompok-2-Simbar/barang
            </div>

            <h3 style="color: #1f2937; font-size: 1.1rem; margin-top: 16px;">4. Halaman Transaksi</h3>
            <div class="url-example correct">
                <span class="badge badge-correct">BENAR</span>
                http://localhost/Kelompok-2-Simbar/transaksi
            </div>
        </div>

        <div class="card">
            <h2>📋 Daftar URL Aplikasi</h2>
            <table>
                <thead>
                    <tr>
                        <th>Halaman</th>
                        <th>URL</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Login</strong></td>
                        <td><code>/Kelompok-2-Simbar/login</code></td>
                        <td>Halaman login - akses pertama kali</td>
                    </tr>
                    <tr>
                        <td><strong>Dashboard</strong></td>
                        <td><code>/Kelompok-2-Simbar/barang/dashboard</code></td>
                        <td>Ringkasan inventaris (memerlukan login)</td>
                    </tr>
                    <tr>
                        <td><strong>Data Barang</strong></td>
                        <td><code>/Kelompok-2-Simbar/barang</code></td>
                        <td>Daftar semua barang (memerlukan login)</td>
                    </tr>
                    <tr>
                        <td><strong>Tambah Barang</strong></td>
                        <td><code>/Kelompok-2-Simbar/barang/tambah</code></td>
                        <td>Form tambah barang baru (memerlukan login)</td>
                    </tr>
                    <tr>
                        <td><strong>Edit Barang</strong></td>
                        <td><code>/Kelompok-2-Simbar/barang/edit/[ID]</code></td>
                        <td>Form edit barang (memerlukan login)</td>
                    </tr>
                    <tr>
                        <td><strong>Transaksi</strong></td>
                        <td><code>/Kelompok-2-Simbar/transaksi</code></td>
                        <td>Riwayat transaksi barang (memerlukan login)</td>
                    </tr>
                    <tr>
                        <td><strong>Input Transaksi</strong></td>
                        <td><code>/Kelompok-2-Simbar/transaksi/tambah</code></td>
                        <td>Form input transaksi baru (memerlukan login)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>🚀 Cara Memulai</h2>
            <ol>
                <li>Pastikan database <code>db_simbar</code> sudah di-import</li>
                <li>Kunjungi halaman setup untuk membuat user test:
                    <a href="setup.php" class="btn">Buka Setup Page</a>
                </li>
                <li>Atau buka login langsung:
                    <a href="../login" class="btn">Login</a>
                </li>
                <li>Login dengan credentials:
                    <ul style="margin-top: 8px;">
                        <li><strong>Username:</strong> admin</li>
                        <li><strong>Password:</strong> admin123</li>
                    </ul>
                </li>
                <li>Setelah login, navigasi ke halaman-halaman menggunakan sidebar menu</li>
            </ol>
        </div>

        <div class="card">
            <h2>🔧 Struktur Folder Aplikasi</h2>
            <p style="margin-bottom: 16px;">Berikut struktur folder project:</p>
            <div style="background: #f1f5f9; padding: 16px; border-radius: 6px; font-family: monospace; font-size: 0.9rem; color: #1f2937; overflow-x: auto;">
<pre>Kelompok-2-Simbar/
├── public/
│   ├── index.php           ← Entry point aplikasi (AKSES DARI SINI!)
│   ├── login/ (routing)
│   ├── barang/ (routing)   ← Data barang (via routing)
│   ├── transaksi/ (routing) ← Riwayat transaksi (via routing)
│   └── assets/
│       ├── css/
│       │   └── style.css   ← Styling aplikasi
│       └── js/
├── app/
│   ├── config/
│   │   └── database.php    ← Konfigurasi database
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── BarangController.php
│   │   └── TransaksiController.php
│   ├── models/
│   │   ├── BarangModel.php
│   │   ├── UserModel.php
│   │   └── TransaksiModel.php
│   ├── views/
│   │   ├── auth/
│   │   ├── barang/         ← Hanya template, JANGAN AKSES LANGSUNG!
│   │   ├── transaksi/      ← Hanya template, JANGAN AKSES LANGSUNG!
│   │   └── layout/
│   └── core/
│       ├── app.php         ← Router
│       └── controller.php  ← Base controller
└── db_simbar.sql           ← Backup database</pre>
            </div>
        </div>

        <div class="card">
            <h2>❓ FAQ</h2>
            <p><strong>Q: Mengapa akses langsung ke /app/views/barang/ tidak bekerja?</strong></p>
            <p>A: File-file di folder <code>app/views/</code> adalah template saja. Mereka memerlukan controller untuk load data dari database, setup session, dan render layout lengkap. Akses langsung hanya menampilkan HTML mentah tanpa styling atau data.</p>

            <p style="margin-top: 20px;"><strong>Q: Apa bedanya /barang dengan /app/views/barang/?</strong></p>
            <ul style="margin-top: 8px;">
                <li><code>/barang</code> → Melalui routing → BarangController → Query database → Render dengan layout + CSS</li>
                <li><code>/app/views/barang/</code> → Direct file access → Tidak ada controller → Tidak ada data → Hanya HTML mentah</li>
            </ul>

            <p style="margin-top: 20px;"><strong>Q: Bagaimana jika login tidak berfungsi?</strong></p>
            <ul style="margin-top: 8px;">
                <li>Cek database connection di <code>app/config/database.php</code></li>
                <li>Pastikan user 'admin' ada di table 'users'</li>
                <li>Buka setup.php untuk membuat user test</li>
                <li>Cek password, jangan lupa di-hash dengan <code>password_hash()</code></li>
            </ul>
        </div>

        <div class="card" style="background: #dcfce7; border-left: 4px solid #16a34a;">
            <h2 style="color: #166534;">✅ Ringkasan</h2>
            <p style="color: #166534;"><strong>Akses aplikasi dengan benar:</strong></p>
            <ul style="color: #166534;">
                <li>JANGAN: <code>http://localhost/Kelompok-2-Simbar/app/views/barang/</code></li>
                <li>GUNAKAN: <code>http://localhost/Kelompok-2-Simbar/login</code> (kemudian navigasi via sidebar)</li>
            </ul>
        </div>
    </div>
</body>
</html>
