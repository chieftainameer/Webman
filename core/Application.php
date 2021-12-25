<?php

namespace app\core;

class Application
{
    public static string $ROOT_PATH;
    public static Application $APP;
    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct()
 {
     self::$ROOT_PATH = dirname(__DIR__);
     self::$APP = $this;
     $this->request = new Request();
     $this->response = new Response();
     $this->router = new Router($this->request,$this->response);
 }

    public function run()
    {
      echo $this->router->resolve();
    }
}