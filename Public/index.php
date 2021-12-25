<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->router->get('/',function(){
    return "shuuup!";
});

$app->router->get('/ameer',function(){
    return "hello ameer hamza";
});
;
$app->run();

