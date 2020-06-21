<?php

namespace App\Data\DB;
use Core\Database\Database;

class Week{
    public static function add_week(Database $connection, $input_week_day, $input_week_type){
        $result = $connection->query('SELECT * FROM add_week(\''.$input_week_day.'\',\''.$input_week_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_week(Database $connection, $input_week_day, $input_week_type){
        $result = $connection->query('SELECT * FROM delete_week(\''.$input_week_day.'\',\''.$input_week_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_week(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_week()');
        $week_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $week_array[$i] = [
                'input_week_day' => $row['input_week_day'],
                'input_week_type' => $row['input_week_type'],
            ];
            $i++;
        }
        return $week_array;
    }

    public static function get_week_id(Database $connection, $input_week_day, $input_week_type){
        $result = $connection->query('SELECT * FROM get_week_id(\''.$input_week_day.'\',\''.$input_week_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_week_by_id(Database $connection, $id_week){
        $result = $connection->query('SELECT * FROM get_week_by_id('.$id_week.')');
        $week_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $week_array[$i] = [
                'input_week_day' => $row['input_week_day'],
                'input_week_type' => $row['input_week_type'],
            ];
            $i++;
        }
        return $week_array;
    }
}