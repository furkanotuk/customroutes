<?php

class CustomRoutes
{
    private $routes = [];
    private $default_directory;
    private $paths = [];
    private $currentSession;

    public function __construct()
    {
        $view_path = __DIR__ . '/../views/view_';
        $controller_path = __DIR__ . '/../controllers/controller_';

        $this->paths = [
            "views" => $view_path,
            "controllers" => $controller_path,
        ];
    }

    public function setDefault($directory)
    {
        $this->default_directory = $directory;
    }

    public function route($pageName, $viewName, $function = null, $requireSession = false)
    {
        $this->routes[$pageName] = [
            'view' => $viewName,
            'function' => $function,
            'requireSession' => $requireSession,
        ];
    }

    public function routeGroup($sessionName, $routes)
    {
        $this->currentSession = $sessionName;

        foreach ($routes as $route) {
            $this->route($route['page'], $route['view'], $route['function'], true);
        }

        $this->currentSession = null;
    }

    public function navigate()
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 'homepage';

        if (array_key_exists($currentPage, $this->routes)) {
            $route = $this->routes[$currentPage];

            if ($route['requireSession'] && !$this->checkSession()) {
                echo "Bu sayfaya erişim izniniz yok.";
                return;
            }

            $this->include($route['view']);

            if (!empty($route['function']) && is_callable($route['function'])) {
                call_user_func($route['function']);
            }
        } else {
            $viewPath = realpath($this->paths["views"] . $currentPage . ".php");
            if (file_exists($viewPath)) {
                $this->include($currentPage);
            } else {
                $this->include($this->default_directory);
            }
        }
    }

    private function include($view)
    {
        $view_file = $this->paths["views"] . $view . ".php";
        $controller_file = $this->paths["controllers"] . $view . ".php";

        if (file_exists($view_file)) {
            include $view_file;
        }

        if (file_exists($controller_file)) {
            include $controller_file;
        }
    }

    private function checkSession()
    {
        return isset($_SESSION[$this->currentSession]);
    }
}
