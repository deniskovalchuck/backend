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
        $groups_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $groups_array[$i] = [
                'id'=>$row['id'],
                'abr_group' => $row['abr_group'],
                'year_entry_group' => $row['year_entry_group'],
                'subgroup' => $row['subgroup'],
                'id_education_type_group' => $row['id_education_type_group'],
            ];
            $i++;
        }
        return $groups_array;
    }

    public static function get_groups_by_id(Database $connection, $id_input_group){
        $result = $connection->query('SELECT * FROM get_groups_by_id('.$id_input_group.')');
        $groups_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $groups_array[$i] = [
                'abr_group' => $row['abr_group'],
                'year_entry_group' => $row['year_entry_group'],
                'subgroup' => $row['subgroup'],
                'id_education_type_group' => $row['id_education_type_group'],
                'id_faculty_group' => $row['id_faculty_group'],
                'id_department_group' => $row['id_department_group'],
                'id_specialization_group' => $row['id_specialization_group'],
            ];
            $i++;
        }
        return $groups_array;
    }

    public static function get_id_student_group(Database $connection, $id_input_lesson, $abbrevation_input_group, $year_entry_input, $name_faculty_input, $name_department_input, $name_specialization_input, $education_type_input, $sub_input_group){
        $result = $connection->query('SELECT * FROM get_id_student_group('.$id_input_lesson.', \''.$abbrevation_input_group.'\', '.$year_entry_input.', \''.$name_faculty_input.'\', \''.$name_department_input.'\', \''.$name_specialization_input.'\', \''.$education_type_input.'\', \''.$sub_input_group.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}