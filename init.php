<?php
define('AppDir' , __DIR__);

//получение namespace
include AppDir.'/configs/init_config.php';
//загрузка всех файлов и инициализация сайта
include AppDir . '/Core/Init/Autoloader.php';
include AppDir . '/Core/Init/router.php';
