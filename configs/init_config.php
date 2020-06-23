<?php
//загружаемые конфиги
define('ConfigsAlias', array(
    'app' => 'app.php',
    'database' => 'database.php',
    'errors' => 'errors.php',

));

$namespaces = array(
    'Core' => 'Core',
    'App' => 'App',
);

define('middleware',array(
    'auth'=>\App\Http\Middleware\AuthMiddleware::class,
    'ConfigDataConverter'=>\App\Http\Middleware\ConfigDataMiddleware::class,
    'AccessLevelOne'=>\App\Http\Middleware\AccessLevelOne::class,
    'AccessLevelTwo'=>\App\Http\Middleware\AccessLevelTwo::class,
    'AccessLevelThree'=>\App\Http\Middleware\AccessLevelThree::class,
    'AccessLevelFour'=>\App\Http\Middleware\AccessLevelFour::class,

));
