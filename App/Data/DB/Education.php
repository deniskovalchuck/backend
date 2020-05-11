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

    /*return string ('Типа обучения не существует!', значение)*/
    public static function get_name_education_type_by_id(Database $connection, $id_input_education_type){
        $result = $connection->query('SELECT * FROM get_name_education_type_by_id(\''.$id_input_education_type.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_education_type(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_education_type()');
        $education_type_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $education_type_array[$i] = [
                'name_input_education_type' => $row['name_input_education_type'],
            ];
            $i++;

        }
        return $education_type_array;
    }
}