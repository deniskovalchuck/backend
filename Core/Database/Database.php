<?php

namespace Core\Database;
use Core\helpers\Config;

//класс базы данных
class Database{
    private $link;
    private $login='';
    private $password='';
    private $host='';
    private $port='';
    private $charset='';
    private $database='';



    /**
     * попытка подключения c указанием имени сервера
     * вернуть true - если подключено, иначе false
     * @param $nameserver   - имя сервера
     * @param $login        - логин пользователя
     * @param $password     - пароль пользователя
     * @return bool         - прошло подключение или нет
     */
    public function tryConnect($nameserver,$login,$password)
    {
       $this->close();
       if($nameserver=='')
           $nameserver=Config::get('database.default_connection');
       $host = Config::get('database.ServerNames.'.$nameserver.'.host');
       $port = Config::get('database.ServerNames.'.$nameserver.'.port');
       $database = Config::get('database.ServerNames.'.$nameserver.'.database');
       $charset = Config::get('database.ServerNames.'.$nameserver.'.charset');

       if($login=='' & $password=='') {
           $login = Config::get('database.ServerNames.' . $nameserver . '.login');
           $password = Config::get('database.ServerNames.' . $nameserver . '.password');
       }

       if($this->connect($host,$port,$database,$login,$password,$charset))
       {
           return true;
       }
       return false;
    }
    /**
     * попытка подключения c указанием всех данных о сервере
     * @param $host     -хост
     * @param $port     -порт
     * @param $database -имя бд
     * @param $login    -логин
     * @param $password -пароль
     * @param $charset  -кодировка
     * @return bool     -подключен ли к серверу - true или false
     */
    public function tryConnectFull($host, $port, $database, $login, $password, $charset)
    {
        $this->close();
        if($this->connect($host,$port,$database,$login,$password,$charset))
        {
            return true;
        }
        return false;
    }

    /**
     * Выполнение запроса
     * @param $sql
     * @return array - результат запроса|null - подключение к бд не устаовлено
     */
    public function query($sql)
    {
        if(!$this->check())
        {
            if (!$this->reconnect())
                return null;
        }
        $result = pg_query($this->link, $sql);
        if (!$result) {
            return false;
        }

        return $result;
    }

    /**
     *Закрытие подключения
     */
    public  function close()
    {
        if($this->link!=null)
            pg_close($this->link);
    }
    /**
     * тут закрыть подключение
     */
    public function __destruct()
    {
       $this->close();
    }



    /**
     * Проверяет - активно ли подключение к бд
     * @return bool - true -активно; false - нет
     */
    private function check()
    {
        if($this->link == null) return false;
        $stat = pg_connection_status($this->link);
        if ($stat === PGSQL_CONNECTION_OK) {
            //echo 'Статус соединения: доступно';
            return true;
        } else {
            // echo 'Статус соединения: разорвано';
            return false;
        }
    }

    /**
     * Осуществляет переподключение к бд
     * @return bool - true - переподключение поизошло успешно; false - нет
     */
    private function reconnect()
    {
        if(empty($this->host)) return false;
        if(empty($this->port)) return false;
        if(empty($this->database)) return false;
        if(empty($this->login)) return false;

        if($this->connect($this->host, $this->port, $this->database, $this->login, $this->password, $this->charset))
            return true;
        return false;
    }
    /**
     * Выполняет подключение к бд
     * @param $host     -хост
     * @param $port     -порт
     * @param $database -имя бд
     * @param $login    -логин
     * @param $password -пароль
     * @param $charset  -кодировка
     * @return bool     -подключен ли к серверу - true или false
     */
    private function connect($host, $port, $database, $login, $password, $charset)
    {
        $conn_string = "host='".$host."' port=".$port." dbname='".$database."' user='".$login."' password='".$password."'";

        try {
            $this->link =pg_connect($conn_string);
            if($this->link == null)
                return false;
            if($charset!='')
            {
                if(pg_set_client_encoding($this->link,$charset)!=0)
                {
                    return false;
                }
            }
        }
        catch (\Exception $ex){
            return false;
        }
        $this->host=$host;
        $this->port=$port;
        $this->database=$database;
        $this->login=$login;
        $this->password=$password;
        $this->charset=$charset;
        return  true;
    }

}
