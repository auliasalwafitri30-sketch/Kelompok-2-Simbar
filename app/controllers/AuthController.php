<?php
/**
 * AuthController.php
 * Mengatur proses login & logout
 */

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    /** Halaman & proses login: /login */
    public function login(): void
    {
        // Kalau sudah login, langsung ke dashboard
        if (!empty($_SESSION['user'])) {
            $this->redirect('barang/dashboard');
            return;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->verifyLogin($username, $password);

            if ($user) {
                // Regenerasi session id untuk mencegah session fixation
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id'           => $user['id'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role'         => $user['role'],
                ];
                $this->redirect('barang/dashboard');
                return;
            }

            $error = 'Username atau password salah.';
        }

        // Tampilkan halaman login TANPA layout sidebar (halaman publik)
        extract(['error' => $error]);
        require_once APP_PATH . '/views/auth/login.php';
    }

    /** Proses logout: /logout */
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('login');
    }
}

