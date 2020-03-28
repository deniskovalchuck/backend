<?php
//root path
define('AppDir' , __DIR__);

//загружаемые конфиги

define('ConfigsPath', array(
    'app' => 'app.php',
    'database' => 'database.php',
    'keys' => 'keys.php',

));


$namespaces = array(
    'Core' => 'Core',
    'App' => 'App',
);
