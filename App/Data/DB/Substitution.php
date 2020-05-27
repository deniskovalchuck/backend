<?php

namespace App\Data\DB;
use Core\Database\Database;

class Substitution{
    public static function create_sub_for_teacher(Database $connection, $login_input_replaceable_teacher,
                                                  $login_input_replacing_teacher, $date_from_sub_teacher,
                                                  $date_to_sub_teacher, $id_input_lesson, $num_input_building,
                                                  $num_input_class, $num_input_lesson){
        $result = $connection->query('SELECT * FROM create_sub_for_teacher('.$login_input_replaceable_teacher.', '.$login_input_replacing_teacher.', '.$date_from_sub_teacher.'::date, '.$date_to_sub_teacher.'::date, '.$id_input_lesson.', '.$num_input_building.', '.$num_input_class.', '.$num_input_lesson.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_sub_for_teacher(Database $connection, $login_input_replaceable_teacher, $login_input_replacing_teacher, $date_from_sub_teacher, $date_to_sub_teacher, $id_input_lesson, $num_input_building, $num_input_class, $num_input_lesson){
        $result = $connection->query('SELECT * FROM delete_sub_for_teacher('.$login_input_replaceable_teacher.', '.$login_input_replacing_teacher.', '.$date_from_sub_teacher.'::date, '.$date_to_sub_teacher.'::date, '.$id_input_lesson.', '.$num_input_building.', '.$num_input_class.', '.$num_input_lesson.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

        public static function get_all_sub_by_teacher(Database $connection, $login_input_teacher){
        $result = $connection->query('SELECT * FROM get_all_sub_by_teacher('.$login_input_teacher.')');
        $sub_info = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $sub_info[$i] = [
                'id_teacher' => $row['id_teacher'], 
                'id_new_teacher' => $row['id_new_teacher'], 
                'date_sub' => $row['date_sub'], 
                'date_from' => $row['date_from'], 
                'id_lesson' => $row['id_lesson'], 
                'id_classroom' => $row['id_classroom'], 
                'num_lesson' => $row['num_lesson'],
            ];
            $i++;
        }
        return $sub_info;
    }

}