<?php
/**
 * public/index.php
 * Entry point aplikasi Simbar
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ==== Konfigurasi Dasar ====
define('APP_PATH', dirname(__DIR__) . '/app');
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/'));
define('APP_URL', BASE_URL . '/index.php?url=');

// ==== Autoload / Load Core Files ====
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/core/controller.php';
require_once APP_PATH . '/core/app.php';

// ==== Routing khusus untuk API (/api/barang, /api/barang/5, dst) ====
$requestUrl = $_GET['url'] ?? '';
$segments   = explode('/', trim($requestUrl, '/'));

// Handle root request - redirect ke login jika belum login
if (empty($requestUrl) || $requestUrl === '') {
    if (!empty($_SESSION['user'])) {
        // Sudah login, tampilkan dashboard inventaris
        header('Location: ' . APP_URL . 'barang/dashboard');
        exit;
    } else {
        // Belum login, mulai dari halaman login
        header('Location: ' . APP_URL . 'login');
        exit;
    }
}

// Handle direct /app/views/ access attempt - redirect to info
if (strpos($requestUrl, 'app/views') !== false) {
    header('Location: ' . BASE_URL . '/info.php');
    exit;
}

if ($segments[0] === 'api' && ($segments[1] ?? '') === 'barang') {
    $apiFile = APP_PATH . '/api/BarangApiController.php';
    if (!file_exists($apiFile)) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Endpoint API tidak tersedia.']);
        exit;
    }
    require_once $apiFile;
    $apiController = new BarangApiController();
    $id = isset($segments[2]) ? (int) $segments[2] : null;
    $apiController->handleRequest($id);
    exit;
}

// ==== Routing normal (web / MVC) ====
$app = new App();

