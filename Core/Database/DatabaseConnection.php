<?php

namespace Core\Database;

//класс базы данных
class Database{


    private $link;

    public function __construct($nameServer)
    {
        
    }
    /**
     * попытка подключения
     * вернуть true - если подключено, иначе false
     */
    public function tryConnect()
    {
        # code...
    }
    public function query($sql)
    {
        # code...
    }

    /**
     * тут закрыть подключение
     */
    public function __destruct()
    {
        # code...
    }


}
