<?php
use Core\Route\Dispatcher;
use Core\Route\Exception\HttpRouteNotFoundException;
use Core\Route\RouteCollector;
//создание роутера
$router = new RouteCollector();
include AppDir.'/Core/Init/filters.php';
//подлкючение файлов с маршрутами
$router->group(['prefix' => 'api'], function($router){
    include AppDir.'/routes/api.php';
});
include AppDir.'/routes/web.php';
//начало обработки маршрутов
$dispatcher = new Dispatcher($router->getData());
try {
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo $response;
}
catch (HttpRouteNotFoundException $exception)
{
    header('Location: /404');
}
