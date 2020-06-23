<?php

namespace App\Data\DB;
use Core\Database\Database;

class Teacher{
    public static function get_teacher_by_login(Database $connection, $teacher_login){
        $result = $connection->query('SELECT * FROM  get_teacher_by_login(\''.$teacher_login.'\')');
        $teacher_array=array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_array[$i] = [
                'name' => $row['name_teacher'],
                'second_name' => $row['second_name_teacher'],
                'third_name' => $row['third_name_teacher'],
                'login_teacher' => $row['login'],
                'photo' => $row['photo_teacher'],
                'faculty_id' => $row['id_teacher_faculty'],
                'department_id' => $row['id_teacher_department'],
                'position_id' => $row['id_teacher_position'],
                'password_teacher' => $row['password_teacher'],
            ];
            $i++;
        }
        return $teacher_array;
    }

    public static function get_teachers_in_faculty(Database $connection, $teacher_faculty_name){
        $result = $connection->query('SELECT * FROM  get_teachers_in_faculty(\''.$teacher_faculty_name.'\')');
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
        $result = $connection->query('SELECT * FROM  get_teachers_in_department(\''.$teacher_faculty_name.'\',\''.$teacher_department_name.'\')');
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
    public static function add_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $login_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher, $photo_input_teacher, $password_teacher, $name_input_access_rights){
        $result = $connection->query('SELECT * FROM add_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$login_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\',\''.$photo_input_teacher.'\',\''.$password_teacher.'\', \''.$name_input_access_rights.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Факультета не существует!', 'Кафедры не существует!', 'Должности не существует!', 'Логин не уникален!', 'Запись уже существует!', 'Запись добавлена!')*/
    public static function add_teacher_with_photo(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $login_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher, $password_teacher, $name_input_access_rights){
        $result = $connection->query('SELECT * FROM add_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$login_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\,\''.$password_teacher.'\', \''.$name_input_access_rights.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Записи не существует!')*/
    public static function delete_teacher(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher, $name_position_input_teacher){
        $result = $connection->query('SELECT * FROM delete_teacher(\''.$name_input_teacher.'\',\''.$second_name_input_teacher.'\',\''.$third_name_input_teacher.'\',\''.$name_faculty_input_teacher.'\',\''.$name_department_input_teacher.'\',\''.$name_position_input_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
    
    public static function get_teacher_info(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher){
        $result = $connection->query('SELECT * FROM get_teacher_info(\''.$name_input_teacher.'\', \''.$second_name_input_teacher.'\', \''.$third_name_input_teacher.'\', \''.$name_faculty_input_teacher.'\', \''.$name_department_input_teacher.'\')');
        $teacher_info = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_info[$i] = [
                'id_input_teacher' => $row['id_input_teacher'],
                'name_teacher' => $row['name_teacher'], 
                'second_name_teacher' => $row['second_name_teacher'], 
                'third_name_teacher' => $row['third_name_teacher'], 
                'login_teacher' => $row['login_teacher'], 
                'name_faculty_teacher' => $row['name_faculty_teacher'], 
                'name_department_teacher' => $row['name_department_teacher'], 
                'name_position_teacher' => $row['name_position_teacher'],
                'photo_input_teacher' => $row['photo_input_teacher'],
                'password_teacher' => $row['password_teacher'],
            ];
            $i++;
        }
        return $teacher_info;
    }

    public static function get_teacher_login(Database $connection, $name_input_teacher, $second_name_input_teacher, $third_name_input_teacher, $name_faculty_input_teacher, $name_department_input_teacher){
        $result = $connection->query('SELECT * FROM get_teacher_login(\''.$name_input_teacher.'\', \''.$second_name_input_teacher.'\', \''.$third_name_input_teacher.'\', \''.$name_faculty_input_teacher.'\', \''.$name_department_input_teacher.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_tacher_by_id(Database $connection, $input_teacher_id){
        $result = $connection->query('SELECT * FROM get_tacher_by_id('.$input_teacher_id.')');
        $teacher_info = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_info[$i] = [
                'name_teacher' => $row['name_teacher'], 
                'second_name_teacher' => $row['second_name_teacher'], 
                'third_name_teacher' => $row['third_name_teacher'], 
                'login_teacher' => $row['login_teacher'], 
                'id_faculty_teacher' => $row['id_faculty_teacher'], 
                'id_department_teacher' => $row['id_department_teacher'], 
                'id_position_teacher' => $row['id_position_teacher'],
                'password_teacher' => $row['password_teacher'],
            ];
            $i++;
        }
        return $teacher_info;
    }

    public static function get_tacher_by_id_with_photo(Database $connection, $input_teacher_id){
        $result = $connection->query('SELECT * FROM get_tacher_by_id_with_photo('.$input_teacher_id.')');
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
                'photo_input_teacher' => $row['photo_input_teacher'],
                'password_teacher' => $row['password_teacher'],
            ];
            $i++;
        }
        return $teacher_info;
    }
    
    public static function get_all_teacher_positions(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_teacher_positions()');
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

    public static function generation_report(Database $connection, $login_input_teacher,
                                             $start_day_in_month, $name_input_type_lesson,
                                             $name_input_payment_type){
        $result = $connection->query('SELECT * FROM generation_report(\''.$login_input_teacher.'\', \''.$start_day_in_month.'\', \''.$name_input_type_lesson.'\', \''.$name_input_payment_type.'\')');
        $teacher_report = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_report[$i] = [
                'Date' => $row['Date'],
                'id_students_groups' => $row['id_students_groups'],
                'id_type_lesson' => $row['id_type_lesson'],
                'num_lesson' => $row['num_lesson'],
                'count_hour' => $row['count_hour'],
            ];
            $i++;
        }
        return $teacher_report;
    }

    public static function get_all_access_right(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_access_right()');
        $teacher_access = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_access[$i] = [
                'id_access_rights' => $row['id_access_rights'],
                'name_access_rights' => $row['name_access_rights'],
                'access_level' => $row['access_level'],
            ];
            $i++;
        }
        return $teacher_access;
    }

    public static function get_access_rights_by_login(Database $connection, $teacher_login){
        $result = $connection->query('SELECT * FROM get_access_rights_by_login(\''.$teacher_login.'\')');
        $teacher_access = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_access[$i] = [
                'name_access_rights' => $row['name_access_rights'],
                'access_level' => $row['access_level'],
            ];
            $i++;
        }
        return $teacher_access;
    }
}