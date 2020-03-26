<?php
namespace App\Core\helpers;

//статический класс для работы с конфигурациями бэкендa
class Config{
    private static $initialized = false;
    private static $ConfigData = array();    
    /**
     * инициализация в память конфигов
     */
    private static function init()
    {
        if (self::$initialized)
        return;
        self::$initialized = true;
        self::$ConfigData['app']=require AppDir.'/configs/app.php';
        self::$ConfigData['database']=require AppDir.'/configs/database.php';
        self::$ConfigData['keys']=require AppDir.'/keys/database.php';
    }
    /**
     * получает значение конфигурации по ключу вида "файл"."ключ"
     * возвращает или значение или null при ошибке
     */
    public static function get($key)
    {
        self::initialize();

    }

}