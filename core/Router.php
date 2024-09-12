<?php

class Router {

    protected static $routes = [];

    // Add a route using both the HTTP method and the URI as keys
    protected static function add($method, $uri, $controller, $action, $view, $data = []){
        self::$routes[$method][$uri] = [
            'controller' => $controller,
            'action'  => $action,
            'view' => $view,
            'data' => $data,
        ];
    }

    // Debugging method to print all routes
    public static function debug(){
        echo "<pre>";
        print_r(self::$routes);
        echo "</pre>";
    }

    // Register GET route
    public static function get($uri, $controller, $action, $view, $data = []){
        self::add('GET', $uri, $controller, $action, $view, $data);
    }
    
    // Register POST route
    public static function post($uri, $controller, $action, $view, $data = []){
        self::add('POST', $uri, $controller, $action, $view, $data);
    }

    // Register DELETE route
    public static function delete($uri, $controller, $action, $view, $data = []){
        self::add('DELETE', $uri, $controller, $action, $view, $data);
    }

    // Register PUT route
    public static function put($uri, $controller, $action, $view, $data = []){
        self::add('PUT', $uri, $controller, $action, $view, $data);
    }

    // Register PATCH route
    public static function patch($uri, $controller, $action, $view, $data = []){
        self::add('PATCH', $uri, $controller, $action, $view, $data);
    }

    // Dispatch the route based on the method and URI
    public static function dispatch($uri) {
        // Clean up the URI
        $uri = trim($uri, '/');
        $requestMethod = $_SERVER['REQUEST_METHOD']; // Get the HTTP method

        // Check if the route exists for the given method and URI
        if (isset(self::$routes[$requestMethod][$uri])) {
            $route = self::$routes[$requestMethod][$uri];
            $controllerName = $route['controller'];
            $action = $route['action'];
            $view = $route['view'];
            $data = $route['data'];

            // Load the correct controller and action
            if ($controllerName == 'Page') {
                $controllerClass = APPROOT . "/core/" . $controllerName . ".php";
                require_once APPROOT . '/core/Theme.php';
                require_once APPROOT . '/core/Helpers.php';
            }

            if ($controllerName == 'Admin') {
                $controllerClass = APPROOT . "/core/admin/" . $controllerName . ".php";
                require_once APPROOT . "/core/Auth.php";
                require_once APPROOT . '/core/admin/AdminTheme.php';
                require_once APPROOT . '/core/admin/AdminHelpers.php';
            }

            if (file_exists(stream_resolve_include_path($controllerClass))) {
                require_once($controllerClass);
                $controllerName::$action($view, $data);
            } else {
                die("Cannot find file @path: " . $controllerClass);
            }
        } else {
            echo "404 - Page not found or method not allowed.";
        }
    }
}
