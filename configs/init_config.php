<?php
//загружаемые конфиги
define('ConfigsAlias', array(
    'app' => 'app.php',
    'database' => 'database.php',
));

$namespaces = array(
    'Core' => 'Core',
    'App' => 'App',
);

define('middleware',array(
    'auth'=>\App\Http\Middleware\AuthMiddleware::class
));
