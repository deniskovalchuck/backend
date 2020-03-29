<?php
//получение namespace
include '../namespaces.php';
//загрузка всех файлов и инициализация сайта
include AppDir.'/Core/helpers/Autoloader.php';

use Core\Route\Dispatcher;
use Core\Route\Exception\HttpRouteNotFoundException;
use Core\Route\RouteCollector;

$router = new RouteCollector();
$router->group(['prefix' => 'api'], function($router){
    include AppDir.'/routes/api.php';
});
include AppDir.'/routes/web.php';

$dispatcher = new Dispatcher($router->getData());
try {
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
echo $response;
}
catch (HttpRouteNotFoundException $exception)
{
    
}
