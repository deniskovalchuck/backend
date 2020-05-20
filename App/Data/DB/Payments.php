<?php

namespace App\Data\DB;
use Core\Database\Database;

class Payments{
    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public static function add_payment_type(Database $connection, $input_name_payment_type, $input_coefficient){
        $result = $connection->query('SELECT * FROM add_payment_type(\''.$input_name_payment_type.'\',\''.$input_coefficient.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Записи нет в базе!')*/
    public static function delete_payment_type(Database $connection, $input_name_payment_type, $input_coefficient){
        $result = $connection->query('SELECT * FROM delete_payment_type(\''.$input_name_payment_type.'\','.$input_coefficient.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_payment_type(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_payment_type()');
        $payment_type_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $payment_type_array[$i] = [
                'name_input_payment_type' => $row['name_input_payment_type'],
                'coefficient_input_payment_type' => $row['coefficient_input_payment_type'],
            ];
            $i++;
        }
        return $payment_type_array;
    }

    public static function get_payment_type_id(Database $connection, $input_name_payment_type, $input_coefficient){
        $result = $connection->query('SELECT * FROM get_week_id(\''.$input_name_payment_type.'\','.$input_coefficient.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_payment_type_by_id(Database $connection, $id_input_payment_type){
        $result = $connection->query('SELECT * FROM get_payment_type_by_id('.$id_input_payment_type.')');
        $payment_type_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $payment_type_array[$i] = [
                'name_input_payment_type' => $row['name_input_payment_type'],
                'coefficient_input_payment_type' => $row['coefficient_input_payment_type'],
            ];
            $i++;
        }
        return $payment_type_array;
    }
}