<?php

namespace App\Data\DB;
use Core\Database\Database;

class Groups{
    public static function add_students_groups(Database $connection, $abbrevation_input_group, $year_entry_input, $name_faculty_input, $name_department_input, $name_specialization_input, $education_type_input, $sub_input_group){
        $result = $connection->query('SELECT * FROM add_students_groups(\''.$abbrevation_input_group.'\',\''.$year_entry_input.'\',\''.$name_faculty_input.'\',\''.$name_department_input.'\',\''.$name_specialization_input.'\',\''.$education_type_input.'\',\''.$sub_input_group.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_student_groups(Database $connection, $abbrevation_input_group, $year_entry_input, $name_faculty_input, $name_department_input, $name_specialization_input, $education_type_input, $sub_input_group){
        $result = $connection->query('SELECT * FROM delete_student_groups(\''.$abbrevation_input_group.'\',\''.$year_entry_input.'\',\''.$name_faculty_input.'\',\''.$name_department_input.'\',\''.$name_specialization_input.'\',\''.$education_type_input.'\',\''.$sub_input_group.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_groups(Database $connection, $faculty_name, $department_name, $specialization_name){
        $result = $connection->query('SELECT * FROM get_all_groups(\''.$faculty_name.'\',\''.$department_name.'\',\''.$specialization_name.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}