<?php

namespace App\Data\DB;
use Core\Database\Database;

class Classrooms{
    public static function get_all_bulding(Database $connection){
        $result =  $connection->query('SELECT * FROM get_all_housing()');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}