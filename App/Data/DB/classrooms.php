<?php

namespace App\Data\DB;
use Core\Database\Database;

class Classrooms{

    public static function get_all_bulding(Database $connection){
        $result =  $connection->query('SELECT * FROM get_all_housing()');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_classrooms(Database $connection){
        $result =  $connection->query('SELECT * FROM get_all_classes()');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_classrooms_in_building(Database $connection, $num_building){
        $result = $connection->query('SELECT * FROM get_all_classes_in_building('.$num_building.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_classroom(Database $connection, $num_input_building, $num_input_class){
        $result = $connection->query('SELECT * FROM add_classroom('.$num_input_building.','.$num_input_class.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_building(Database $connection, $num_building_for_delete){
        $result = $connection->query('SELECT * FROM delete_building('.$num_building_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_classroom(Database $connection, $num_building_for_delete, $num_class_for_delete){
        $result = $connection->query('SELECT * FROM delete_classroom('.$num_building_for_delete.','.$num_class_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}