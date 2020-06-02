<?php

namespace App\Data\DB;
use Core\Database\Database;

class Schedule{
    public static function add_schedule(Database $connection, $id_input_student_group, $start_input_education, $end_input_education, $start_input_session, $end_input_session){
        $result = $connection->query('SELECT * FROM add_schedule('.$id_input_student_group.', \''.$start_input_education.'\', \''.$end_input_education.'\', \''.$start_input_session.'\', \''.$end_input_session.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_schedule(Database $connection, $id_input_student_group, $start_input_education, $end_input_education, $start_input_session, $end_input_session){
        $result = $connection->query('SELECT * FROM delete_schedule('.$id_input_student_group.', \''.$start_input_education.'\', \''.$end_input_education.'\', \''.$start_input_session.'\', \''.$end_input_session.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_schedule(Database $connection){
        $result = $connection->query('SELECT * FROM get_schedule_for_group()');
        $schedule_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $schedule_array[$i] = [
                'id_student_group' => $row['id_student_group'],
                'start_education' => $row['start_education'],
                'end_education' => $row['end_education'],
                'start_session' => $row['start_session'],
                'end_session' => $row['end_session'],
            ];
            $i++;
        }
        return $schedule_array;
    }

    public static function get_id_training_schedule(Database $connection, $start_input_education, $end_input_education, $start_input_session, $end_input_session, $id_input_student_group){
        $result = $connection->query('SELECT * FROM get_id_training_schedule('.$start_input_education.', \''.$end_input_education.'\', \''.$start_input_session.'\', \''.$end_input_session.'\', \''.$id_input_student_group.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_schedule_for_group(Database $connection, $id_input_student_group){
        $result = $connection->query('SELECT * FROM get_schedule_for_group('.$id_input_student_group.')');
        $schedule_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $schedule_array[$i] = [
                'id_student_group' => $row['id_student_group'],
                'start_education' => $row['start_education'],
                'end_education' => $row['end_education'],
                'start_session' => $row['start_session'],
                'end_session' => $row['end_session'],
            ];
            $i++;
        }
        return $schedule_array;
    }
}