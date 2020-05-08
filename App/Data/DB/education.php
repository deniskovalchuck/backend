<?php

namespace App\Data\DB;
use Core\Database\Database;

class Education{
    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public static function add_education_type(Database $connection, $name_input_education_type){
        $result = $connection->query('SELECT * FROM add_education_type(\''.$name_input_education_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Записи нет в базе!')*/
    public static function delete_education_type(Database $connection, $name_input_education_type){
        $result = $connection->query('SELECT * FROM delete_education_type(\''.$name_input_education_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_education_type(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_education_type()');
        $education_type_array = array();
        while($row = pg_fetch_assoc($result)){
            $education_type_array = [
                'name_input_education_type' => $row['name_input_education_type'],
            ];
        }
        return $education_type_array;
    }
}