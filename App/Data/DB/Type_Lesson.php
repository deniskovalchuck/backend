<?php

namespace App\Data\DB;
use Core\Database\Database;

class Type_Lesson{
    public static function add_type_lesson(Database $connection, $input_name_type_lesson, $input_type_education){
        $result = $connection->query('SELECT * FROM add_type_lesson(\''.$input_name_type_lesson.'\',\''.$input_type_education.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_type_lesson(Database $connection, $input_name_type_lesson, $input_type_education){
        $result = $connection->query('SELECT * FROM delete_type_lesson(\''.$input_name_type_lesson.'\',\''.$input_type_education.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_type_lesson_id(Database $connection, $input_name_type_lesson, $input_type_education){
        $result = $connection->query('SELECT * FROM get_type_lesson_id(\''.$input_name_type_lesson.'\',\''.$input_type_education.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_type_lesson_by_id(Database $connection, $id_input_type_lesson){
        $result = $connection->query('SELECT * FROM get_type_lesson_by_id('.$id_input_type_lesson.')');
        $type_lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $type_lessons_array[$i] = [
                'name_type_lesson' => $row['name_type_lesson'],
                'name_type_education' => $row['name_type_education'],
            ];
            $i++;

        }
        return $type_lessons_array;
    }

    //таблица type lesson
    public static function get_all_type_lesson(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_type_lesson()');
        $type_lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $type_lessons_array[$i] = [
                'type_lessons' => $row['type_lessons'],
                'name_type_education' => $row['name_type_education'],
            ];
            $i++;

        }
        return $type_lessons_array;
    }

    public static function get_all_type_lesson_by_name_type_education(Database $connection, $name_input_type_education){
        $result = $connection->query('SELECT * FROM get_all_type_lesson_by_name_type_education(\''.$name_input_type_education.'\')');
        $type_lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $type_lessons_array[$i] = [
                'name_input_type_lesson' => $row['name_input_type_lesson'],
            ];
            $i++;

        }
        return $type_lessons_array;
    }
}