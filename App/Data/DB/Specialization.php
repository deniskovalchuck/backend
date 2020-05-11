<?php

namespace App\Data\DB;
use Core\Database\Database;

class Specialization{
    public static function get_all_specialization(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_specialization()');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_specialization_from_faculty(Database $connection, $name_input_faculty){
        $result = $connection->query('SELECT * FROM get_all_specialization_from_faculty(\''.$name_input_faculty.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_specialization_from_department(Database $connection, $name_input_department){
        $result = $connection->query('SELECT * FROM get_all_specialization_from_department(\''.$name_input_department.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_spezialization(Database $connection, $name_input_specialization, $name_input_faculty, $name_input_department, $abbreviation){
        $result = $connection->query('SELECT * FROM add_spezialization(\''.$name_input_specialization.'\',\''.$name_input_faculty.'\',\''.$name_input_department.'\',\''.$abbreviation.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_specialization(Database $connection, $name_faculty_for_delete, $name_department_for_delete, $name_specialization_for_delete){
        $result = $connection->query('SELECT * FROM delete_specialization(\''.$name_faculty_for_delete.'\',\''.$name_department_for_delete.'\',\''.$name_specialization_for_delete.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}