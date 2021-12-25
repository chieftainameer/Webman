<?php

namespace app\core;

class Router
{
    private Request $request;
    protected $routes = [];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function get($path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false)
        {
            echo "Route Not Found";
            exit;
        }
        echo call_user_func($callback);

        echo '<pre>';
        var_dump($this->routes);
        echo '</pre>';
        exit;
    }
}