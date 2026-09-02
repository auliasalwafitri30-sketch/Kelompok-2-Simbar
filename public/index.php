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
define('BASE_URL', ''); // isi contoh: '/simbar-app/public' jika perlu subfolder

// ==== Autoload / Load Core Files ====
require_once APP_PATH . '/config/Database.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/App.php';

// ==== Routing khusus untuk API (/api/barang, /api/barang/5, dst) ====
$requestUrl = $_GET['url'] ?? '';
$segments   = explode('/', trim($requestUrl, '/'));

if ($segments[0] === 'api' && ($segments[1] ?? '') === 'barang') {
    require_once APP_PATH . '/api/BarangApiController.php';
    $apiController = new BarangApiController();
    $id = isset($segments[2]) ? (int) $segments[2] : null;
    $apiController->handleRequest($id);
    exit;
}

// ==== Routing normal (web / MVC) ====
$app = new App();

