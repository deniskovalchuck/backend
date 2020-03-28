<?php
namespace Core\helpers;

//статический класс для работы с конфигурациями бэкендa
class Config{
    private static $initialized = false;
    private static $ConfigData = array();    
    /**
     * инициализация в память конфигов
     */
    public static function init()
    {
        if (self::$initialized)
        return;
        self::$initialized = true;
        foreach ( ConfigsPath as $key => $value )
        {
            try {
                self::$ConfigData[$key]=require AppDir.'/configs/'.$value;
            }
            catch (\Exception $ex)
            {
                die('Error loading file: '.$value. ' with error '.$ex->getMessage());
            }
        }
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
