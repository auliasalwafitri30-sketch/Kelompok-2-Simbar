<?php
/**
 * Controller.php
 * Controller dasar - menyediakan helper load model & view
 */

class Controller
{
    /**
     * Panggil di awal constructor controller yang membutuhkan login
     * (semua controller KECUALI AuthController).
     */
    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }
    }

    protected function currentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    protected function model(string $modelName)
    {
        require_once APP_PATH . '/models/' . $modelName . '.php';
        return new $modelName();
    }

    protected function view(string $viewPath, array $data = [])
    {
        extract($data);
        $viewFile = APP_PATH . '/views/' . $viewPath . '.php';

        if (file_exists($viewFile)) {
            require_once APP_PATH . '/views/layout/header.php';
            require_once $viewFile;
            require_once APP_PATH . '/views/layout/footer.php';
        } else {
            die('View tidak ditemukan: ' . $viewPath);
        }
    }

    protected function json($data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . APP_URL . ltrim($path, '/'));
        exit;
    }
}

