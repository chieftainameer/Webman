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

    public function post($path,$callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false)
        {
//            $this->response->setStatucCode(404); // both are valid ways to access Response class
            Application::$APP->response->setStatucCode(404);
            return $this->renderView('_404',true);
        }
        if (is_string($callback))
        {
            // if this is a string then we are passing a name of a view..so render it
            return $this->renderView($callback);
        }
        else
        {
            // if the passed value os not a view then it is a callback function which should be executed righti way
            return call_user_func($callback);
        }
    }

    public function renderView($view,$viewTypeError=false){
        $extendedView = $this->extendedView($view,$viewTypeError);
        $layoutView = $this->layoutView();
        $mainView = str_replace('{{content}}',$extendedView,$layoutView);
        return $mainView;
    }

    protected function extendedView($view,$viewTypeError=false)
    {
        $path = $viewTypeError ? Application::$ROOT_PATH."/Views/errors/" : Application::$ROOT_PATH."/Views/";
        ob_start();
        include_once $path.$view.".php";
        return ob_get_clean();
    }

    protected function layoutView()
    {
        ob_start();
        include_once Application::$ROOT_PATH."/Views/layouts/main.php";
        return ob_get_clean();
    }
}