<?php

namespace App\Data\DB;
use Core\Database\Database;

class Teacher{
    public static function get_teacher_by_login(Database $connection, $teacher_login){
        $result = $connection->query('SELECT * FROM get_teacher_by_login(\''.$teacher_login.'\')');
        $teacher_array=array();
        while($row = pg_fetch_assoc($result)){
            $teacher_array = [
                'name' => 'name',
                'second_name' => 'second_name',
                'third_name' => 'third_name',
                'login_teacher' => 'login_teacher',
                'photo' => 'photo',
                'faculty_id' => 'faculty_id',
                'department_id' => 'department_id',
                'position_id' => 'position_id',
            ];
        }
        return $teacher_array;
    }

    public static function get_teachers_in_faculty(Database $connection, $teacher_faculty_name){
        $result = $connection->query('SELECT * FROM get_teachers_in_faculty('.$teacher_faculty_name.')');
        while($row = pg_fetch_assoc($result)){
            $teacher_array = [
                'name' => 'name',
                'second_name' => 'second_name',
                'third_name' => 'third_name',
                'login_teacher' => 'login_teacher',
                'photo' => 'photo',
                'faculty_id' => 'faculty_id',
                'department_id' => 'department_id',
                'position_id' => 'position_id',
            ];
        }
        return $teacher_array;
    }

    public static function get_teachers_in_department(Database $connection, $teacher_faculty_name, $teacher_department_name){
        $result = $connection->query('SELECT * FROM get_teachers_in_faculty('.$teacher_faculty_name.','.$teacher_department_name.')');
        while($row = pg_fetch_assoc($result)){
            $teacher_array = [
                'name' => 'name',
                'second_name' => 'second_name',
                'third_name' => 'third_name',
                'login_teacher' => 'login_teacher',
                'photo' => 'photo',
                'faculty_id' => 'faculty_id',
                'department_id' => 'department_id',
                'position_id' => 'position_id',
            ];
        }
        return $teacher_array;
    }

    public static function add_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $login_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher, $input_email, $photo_input_teacher){
        $result = $connection->query('add_teacher('.$name_input_teacher.','.$second_name_input_teacher.','.$third_name_input_teacher.','.$login_input_teacher.','.$name_faculty_input_teacher.','.$name_department_input_teacher.','.$name_position_input_teacher.','.$input_email.','.$photo_input_teacher.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher){
        $result = $connection->query('delete_teacher('.$name_input_teacher.','.$second_name_input_teacher.','.$third_name_input_teacher.','.$name_faculty_input_teacher.','.$name_department_input_teacher.','.$name_position_input_teacher.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}