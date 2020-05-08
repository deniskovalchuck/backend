<?php

namespace App\Data\DB;
use Core\Database\Database;


//Subject - дисциплины


class Subjects{
    public static function get_all_subjects(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_subjects()');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_subject(Database $connection, $name_input_subject){
        $result = $connection->query('SELECT * FROM add_subject('.$name_input_subject.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_subject(Database $connection, $name_subject_for_delete){
        $result = $connection->query('SELECT * FROM delete_subject('.$name_subject_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_teacher_subjects(Database $connection, $login_input_teacher){
        $result = $connection->query('SELECT * FROM get_teacher_subjects('.$login_input_teacher.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_teacher_subjects_by_FIO(Database $connection, $name_input_teacher, $second_input_name_teacher, $third_input_name_teacher, $name_subject){
        $result = $connection->query('SELECT * FROM add_teacher_subjects('.$name_input_teacher.','.$second_input_name_teacher.','.$third_input_name_teacher.','.$name_subject.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_teacher_subjects_by_login(Database $connection, $login_input_teacher, $name_input_subject){
        $result = $connection->query('SELECT * FROM add_teacher_subjects('.$login_input_teacher.','.$name_input_subject.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Преподавателя не существует!', 'Предмета не существует!', 'Запись успешно удалена!')*/
    public static function delete_teacher_subjects(Database $connection, $login_input_teacher, $name_input_subject){
        $result = $connection->query('SELECT * FROM delete_teacher_subjects('.$login_input_teacher.','.$name_input_subject.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}