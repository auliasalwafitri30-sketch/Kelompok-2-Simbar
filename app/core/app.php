<?php
/**
 * App.php
 * Front Controller sederhana (router) untuk aplikasi Simbar.
 *
 * URL format didukung: index.php?url=barang/tambah/3
 * Dengan .htaccess di /public -> menjadi: /barang/tambah/3
 */

class App
{
    protected  $controller = 'BarangController';
    protected  $method     = 'index';
    protected  $params     = [];

    // Alias URL pendek -> [Controller, method]
    private $routeAliases = [
        'login'  => ['Auth', 'login'],
        'logout' => ['Auth', 'logout'],
    ];

    public function __construct()
    {
        $url = $this->parseUrl();

        // 0. Cek alias route (mis. /login -> AuthController::login)
        if (isset($url[0]) && isset($this->routeAliases[$url[0]])) {
            [$aliasController, $aliasMethod] = $this->routeAliases[$url[0]];
            $url[0] = $aliasController;
            // sisipkan method alias di posisi ke-2 kalau belum ada segment method
            if (!isset($url[1]) || $url[1] === '') {
                $url[1] = $aliasMethod;
            } else {
                array_splice($url, 1, 0, $aliasMethod);
            }
        }

        // 1. Tentukan Controller
        if (isset($url[0]) && $url[0] !== '') {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $controllerName;
                require_once $controllerFile;
                unset($url[0]);
            }
        }

        $controllerInstance = new $this->controller();

        // 2. Tentukan Method
        if (isset($url[1]) && $url[1] !== '') {
            if (method_exists($controllerInstance, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Tentukan Parameter
        $this->params = $url ? array_values($url) : [];

        // 4. Jalankan
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}

