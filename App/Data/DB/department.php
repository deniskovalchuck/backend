<?php

namespace App\Data\DB;
use Core\Database\Database;

class Department{
    public static function get_all_departments(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_departments()');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_departments_in_faculty(Database $connection, $name_input_faculty){
        $result = $connection->query('SELECT * FROM get_all_departments_in_faculty('.$name_input_faculty.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_departments_in_faculty_with_logo(Database $connection, $name_input_faculty){
        $result = $connection->query('SELECT * FROM get_all_departments_in_faculty_with_logo('.$name_input_faculty.')');
        while($row = pg_fetch_assoc($result)){
            $department_array = [
                'name_departments' => 'name_departments',
                'logo_departments' => 'logo_departments',
            ];
        }
        return $department_array;
    }

    public static function add_department(Database $connection, $name_input_department, $logo_input_department, $name_faculty_input_department, $num_building_input_department, $num_class_input_department){
        $result = $connection->query('SELECT * FROM add_department('.$name_input_department.','.$logo_input_department.','.$name_faculty_input_department.','.$num_building_input_department.','.$num_class_input_department.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_department(Database $connection, $name_faculty_for_delete, $name_department_for_delete){
        $result = $connection->query('SELECT * FROM delete_department('.$name_faculty_for_delete.','.$name_department_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}