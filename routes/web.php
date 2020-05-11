<?php
//маршрут по умолчанию
$router->any('*', function ()
{
    return  file_get_contents(AppDir.'/views/index.html');
});

