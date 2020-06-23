<?php

namespace App\Data\DB;
use Core\Database\Database;

class Holidays{
    public static function add_holiday(Database $connection, $name_input_holiday,
                                       $date_input_holiday_from, $date_input_holiday_to){
        $result = $connection->query('SELECT * FROM add_holiday(\''.$name_input_holiday.'\', \''.$date_input_holiday_from.'\', \''.$date_input_holiday_to.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_holiday(Database $connection, $id_input_holidays){
        $result = $connection->query('SELECT * FROM delete_holiday(\''.$id_input_holidays.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_holidays(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_holidays()');
        $holidays_info = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $holidays_info[$i] = [
                'id_holidays' => $row['id_holidays'], 
                'name_holiday' => $row['name_holiday'], 
                'date_holiday_from' => $row['date_holiday_from'], 
                'date_holiday_to' => $row['date_holiday_to'],
            ];
            $i++;
        }
        return $holidays_info;
    }
}