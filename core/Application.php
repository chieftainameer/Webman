<?php

namespace app\core;

class Application
{
    public static string $ROOT_PATH;
 public Router $router;
 public Request $request;

    public function __construct()
 {
     self::$ROOT_PATH = dirname(__DIR__);
     $this->request = new Request();
     $this->router = new Router($this->request);
 }

    public function run()
    {
      echo $this->router->resolve();
    }
}