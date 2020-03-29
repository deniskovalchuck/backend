<?php
$router->any('/', function ()
{
    return  '1';
},['before'=>'auth']);

//маршрут по умолчанию
$router->any('*', function ()
{
    return  '404s';
});

