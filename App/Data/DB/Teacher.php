<?php

namespace App\Data\DB;
use Core\Database\Database;

class Teacher{
    public static function get_teacher_by_login(Database $connection, $teacher_login){
        $result = $connection->query('SELECT * FROM get_teacher_by_login(\''.$teacher_login.'\')');
        $teacher_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_array[$i] = [
                'name' => $row['name'],
                'second_name' => $row['second_name'],
                'third_name' => $row['third_name'],
                'login_teacher' => $row['login_teacher'],
                'photo' => $row['photo'],
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'position_id' => $row['position_id'],
            ];
            $i++;
        }
        return $teacher_array;
    }

    public static function get_teachers_in_faculty(Database $connection, $teacher_faculty_name){
        $result = $connection->query('SELECT * FROM get_teachers_in_faculty(\''.$teacher_faculty_name.'\')');
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_array[$i] = [
                'name' => $row['name'],
                'second_name' => $row['second_name'],
                'third_name' => $row['third_name'],
                'login_teacher' => $row['login_teacher'],
                'photo' => $row['photo'],
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'position_id' => $row['position_id'],
            ];
            $i++;
        }
        return $teacher_array;
    }

    public static function get_teachers_in_department(Database $connection, $teacher_faculty_name, $teacher_department_name){
        $result = $connection->query('SELECT * FROM get_teachers_in_faculty(\''.$teacher_faculty_name.'\',\''.$teacher_department_name.'\')');
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_array[$i] = [
                'name' => $row['name'],
                'second_name' => $row['second_name'],
                'third_name' => $row['third_name'],
                'login_teacher' => $row['login_teacher'],
                'photo' => $row['photo'],
                'faculty_id' => $row['faculty_id'],
                'department_id' => $row['department_id'],
                'position_id' => $row['position_id'],
            ];
            $i++;
        }
        return $teacher_array;
    }

    /*return string ('Факультета не существует!', 'Кафедры не существует!', 'Должности не существует!', 'Логин не уникален!', 'Запись уже существует!', 'Запись добавлена!')*/
    public static function add_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $login_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher, $photo_input_teacher){
        $result = $connection->query('SELECT * add_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$login_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\',\''.$photo_input_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Факультета не существует!', 'Кафедры не существует!', 'Должности не существует!', 'Логин не уникален!', 'Запись уже существует!', 'Запись добавлена!')*/
    public static function add_teacher_with_photo(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $login_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher){
        $result = $connection->query('SELECT * add_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$login_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\)');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Записи не существует!')*/
    public static function delete_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher){
        $result = $connection->query('SELECT * delete_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
    
    public static function get_teacher_info(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher){
        $result = $connection->query('SELECT * get_teacher_info(\''.$name_input_teacher.'\', \''.$second_name_input_teacher.'\', \''.$third_name_input_teacher.'\', \''.$name_faculty_input_teacher.'\', \''.$name_department_input_teacher.'\', \''.$name_position_input_teacher.'\')');
        $teacher_info = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_info[$i] = [
                'name_teacher' => $row['name_teacher'], 
                'second_name_teacher' => $row['second_name_teacher'], 
                'third_name_teacher' => $row['third_name_teacher'], 
                'login_teacher' => $row['login_teacher'], 
                'name_faculty_teacher' => $row['name_faculty_teacher'], 
                'name_department_teacher' => $row['name_department_teacher'], 
                'name_position_teacher' => $row['name_position_teacher'], 
                'input_email' => $row['input_email'], 
                'photo_input_teacher' => $row['photo_input_teacher'],
            ];
            $i++;
        }
        return $teacher_info;
    }

    public static function get_teacher_login(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher){
        $result = $connection->query('SELECT * get_teacher_login(\''.$name_input_teacher.'\', \''.$second_name_input_teacher.'\', \''.$third_name_input_teacher.'\', \''.$name_faculty_input_teacher.'\', \''.$name_department_input_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function create_sub_for_teacher(Database $connection, $login_replaceable_teacher, $login_replacing_teacher, $date_sub_teacher){
        $result = $connection->query('SELECT * create_sub_for_teacher(\''.$login_replaceable_teacher.'\',\''.$login_replacing_teacher.'\',\''.$date_sub_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_sub_for_teacher(Database $connection, $login_replaceable_teacher, $login_replacing_teacher, $date_sub_teacher){
        $result = $connection->query('SELECT * delete_sub_for_teacher(\''.$login_replaceable_teacher.'\',\''.$login_replacing_teacher.'\',\''.$date_sub_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_teacher_positions(Database $connection){
        $result = $connection->query('SELECT * get_all_teacher_positions()');
        $teacher_positions = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_positions[$i] = [
                'teachers_positions' => $row['teachers_positions'],
            ];
            $i++;
        }
        return $teacher_positions;
    }
}