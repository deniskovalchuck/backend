<?php

namespace App\Data\DB;
use Core\Database\Database;

class Department{
    public static function get_all_departments(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_departments()');
        $department_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $department_array[$i] = [
                'name_departments' => $row['name_depatments'],
                'num_housing' => $row['num_housing'],
                'num_class' => $row['num_class'],
                'name_faculty' => $row['name_faculty'],
            ];
            $i++;
        }
        return $department_array;
    }

    public static function get_all_departments_with_logo(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_departments_with_logo()');
        $department_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $department_array[$i] = [
                'name_departments' => $row['name_depatments'],
                'logo_departments' => $row['logo_depatments'],
                'num_housing' => $row['num_housing'],
                'num_class' => $row['num_class'],
                'name_faculty' => $row['name_faculty'],
            ];
            $i++;
        }
        return $department_array;
    }

    public static function get_all_departments_in_faculty(Database $connection, $name_input_faculty){
        $result = $connection->query('SELECT * FROM get_all_departments_in_faculty('.$name_input_faculty.')');
        $department_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $department_array[$i] = [
                'name_departments' => $row['name_depatments'],
                'num_housing' => $row['num_housing'],
                'num_class' => $row['num_class'],
                'name_faculty' => $row['name_faculty'],
            ];
            $i++;
        }
        return $department_array;
    }

    public static function get_all_departments_in_faculty_with_logo(Database $connection, $name_input_faculty){
        $result = $connection->query('SELECT * FROM get_all_departments_in_faculty_with_logo('.$name_input_faculty.')');
        $department_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $department_array[$i] = [
                'name_departments' => $row['name_depatments'],
                'logo_departments' => $row['logo_depatments'],
                'num_housing' => $row['num_housing'],
                'num_class' => $row['num_class'],
                'name_faculty' => $row['name_faculty'],
            ];
            $i++;
        }
        return $department_array;
    }
    /*return string ('Факультета несуществует!', 'Кафедры не существует!', 'Запись успешно удалена!')*/
    public static function add_department(Database $connection, $name_input_department, $logo_input_department, $name_faculty_input_department, $num_building_input_department, $num_class_input_department){
        $result = $connection->query('SELECT * FROM add_department(\''.$name_input_department.'\',\''.$logo_input_department.'\',\''.
            $name_faculty_input_department.'\',\''.$num_building_input_department.'\',\''.$num_class_input_department.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Факультета несуществует!', 'Аудитории несуществует!', 'Запись уже существует!', 'Запись добавлена!')*/
    public static function delete_department(Database $connection, $name_faculty_for_delete, $name_department_for_delete){
        $result = $connection->query('SELECT * FROM delete_department('.$name_faculty_for_delete.','.$name_department_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}