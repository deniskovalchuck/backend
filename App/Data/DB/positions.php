<?php

namespace App\Data\DB;
use Core\Database\Database;

class Position{

    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public static function add_position(Database $connection, $name_input_position){
        $result = $connection->query('SELECT * FROM add_position(\''.$name_input_position.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Записи нет в базе!')*/
    public static function delete_teacher_position(Database $connection, $name_teacher_position){
        $result = $connection->query('SELECT * FROM delete_teacher_position(\''.$name_teacher_position.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_teacher_positions(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_teacher_positions()');
        $positions_array = array();
        while($row = pg_fetch_assoc($result)){
            $positions_array = [
                'teachers_positions' => $row['teachers_positions'],
            ];
        }
        return $positions_array;
    }
}