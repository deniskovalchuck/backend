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
        foreach ( ConfigsAlias as $key => $value )
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
        self::init();
        $values = explode(".", $key);

        $result = Config::$ConfigData;
        foreach ($values as $item)
        {
            $result = $result[$item];
        }
        return $result;
    }

    private static function _set($key,$value,$source=null)
    {
        $keys = explode(".", $key);
        if(count($keys)>1)
        {
            $tmp = array_shift($keys);
            if(array_key_exists ($tmp,$source) == false)
                $source[$tmp] = array();
            $source[$tmp]=  set(implode('.', $keys),$value,$source[$tmp]);

            return $source;
        }
        else{
            $source[$key]=$value;
            return $source;
        }
    }
    public static function set($key,$value,$source=null)
    {
        Config::$ConfigData=Config::_set($key,$value,Config::$ConfigData);
    }
}
