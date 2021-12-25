<?php

namespace app\core;

class Router
{
    private Request $request;
    protected $routes = [];
    private Response $response;

    public function __construct($request,$response)
    {
        $this->request = $request;
        $this->response = $response;
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
//            $this->response->seetStatucCode(404); // both are valid ways to access Response class
            Application::$APP->response->seetStatucCode(404);
            return "Route Not Found";
        }
        if (is_string($callback))
        {
            return $this->renderView($callback);
        }
        else
        {
            return call_user_func($callback);
        }
    }

    public function renderView($view){
        $extendedView = $this->extendedView($view);
        $layoutView = $this->layoutView();
        $mainView = str_replace('{{content}}',$extendedView,$layoutView);
        return $mainView;
    }

    protected function extendedView($view)
    {
        ob_start();
        include_once Application::$ROOT_PATH."/Views/$view.php";
        return ob_get_clean();
    }

    protected function layoutView()
    {
        ob_start();
        include_once Application::$ROOT_PATH."/Views/layouts/main.php";
        return ob_get_clean();
    }
}