<?php

namespace App\Data\DB;
use Core\Database\Database;

//Уроки, занятия, связанные с днями недель и с преподами. Сам УРОК

class Lesson{
    /*return integer (-1 - error)*/
    public static function get_id_lesson(Database $connection, $name_input_type_lesson, $name_input_payment_type, $num_input_lesson, $week_input_day, $week_input_type, $subject_name){
        $result = $connection->query('SELECT * FROM get_id_lesson(\''.$name_input_type_lesson.'\', \''.$name_input_payment_type.'\', \''.$num_input_lesson.'\', \''.$week_input_day.'\', \''.$week_input_type.'\', \''.$subject_name.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return integer (-1 - error)*/
    public static function add_lesson(Database $connection, $name_input_type_lesson, $name_input_payment_type, $week_input_type, $week_input_day, $num_input_lesson,$subject_name){
        $result = $connection->query('SELECT * FROM add_lesson(\''.$name_input_type_lesson.'\', \''.$name_input_payment_type.'\', \''.$week_input_type.'\', \''.$week_input_day.'\', \''.$num_input_lesson.'\',\''.$subject_name.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    /*return string ('Запись успешно удалена!', 'Занятия нет в базе!')*/
    public static function delete_lesson(Database $connection, $id_input_lesson){
        $result = $connection->query('SELECT * delete_lesson(\''.$id_input_lesson.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function get_all_lessons(Database $connection){
        $result = $connection->query('SELECT * FROM get_all_lessons()');
        $lessons_array = array();
        $i=0;

        while($row = pg_fetch_assoc($result)){
            $lessons_array[$i] = [
                'num_lesson' => $row['num_lesson'],
                'id_week_day' => $row['id_week_day'],
                'id_type_lesson' => $row['id_type_lesson'],
                'id_payment_type' => $row['id_payment_type'],
            ];
            $i++;

        }
        return $lessons_array;
    }

    public static function get_lesson_by_id(Database $connection, $id_input_lesson){
        $result = $connection->query('SELECT * FROM get_lesson_by_id('.$id_input_lesson.')');
        $lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $lessons_array[$i] = [
                'num_lesson' => $row['num_lesson'],
                'id_week_day' => $row['id_week_day'],
                'id_type_lesson' => $row['id_type_lesson'],
                'id_payment_type' => $row['id_payment_type'],
            ];
            $i++;

        }
        return $lessons_array;
    }

    public static function get_all_lessons_by_group(Database $connection, $abbrevation_input_group, $year_entry_input, $name_faculty_input, $name_department_input, $name_specialization_input, $education_type_input, $sub_input_group){
        $result = $connection->query('SELECT * FROM get_all_lessons_by_group(\''.$abbrevation_input_group.'\', \''.$year_entry_input.', \''.$name_faculty_input.', \''.$name_department_input.'\', \''.$name_specialization_input.'\', \''.$education_type_input.'\', \''.$sub_input_group.'\')');
        $group_lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $group_lessons_array[$i] = [
                'id_type_lesson' => $row['id_type_lesson'],
                'num_lesson' => $row['num_lesson'],
                'id_lesson' => $row['id_lesson'],
                'id_week_day' => $row['id_week_day'],
                'id_groups_on_lesson' => $row['id_groups_on_lesson'],
                'id_teachers_on_lesson' => $row['id_teachers_on_lesson'],
            ];
            $i++;

        }
        return $group_lessons_array;
    }

    public static function get_all_lessons_by_teacher(Database $connection, $login_input_teacher){
        $result = $connection->query('SELECT * FROM get_all_lessons_by_teacher(\''.$login_input_teacher.'\')');
        $teacher_lessons_array = array();
        $i=0;
        while($row = pg_fetch_assoc($result)){
            $teacher_lessons_array[$i]  = [
                'id_type_lesson' => $row['id_type_lesson'], 
                'id_payment_type_on_lesson' => $row['id_payment_type_on_lesson'], 
                'num_lesson' => $row['num_lesson'], 
                'week_day' => $row['week_day'], 
                'id_groups_on_lesson' => $row['id_groups_on_lesson'], 
                'id_teachers_on_lesson' => $row['id_teachers_on_lesson'],
            ];
            $i++;
        }
        return $teacher_lessons_array;
    }

    public static function add_teachers_on_lesson(Database $connection, $login_input_teacher, $id_input_lesson){
        $result = $connection->query('SELECT * FROM add_teachers_on_lesson(\''.$login_input_teacher.'\', '.$id_input_lesson.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function add_groups_on_lesson(Database $connection, $id_input_lesson, $abbrevation_input_group, $year_entry_input, $name_faculty_input, $name_department_input, $name_specialization_input, $sub_input_group){
        $result = $connection->query('SELECT * FROM add_groups_on_lesson('.$id_input_lesson.', \''.$abbrevation_input_group.'\', '.$year_entry_input.', \''.$name_faculty_input.'\', \''.$name_department_input.'\', \''.$name_specialization_input.'\', \''.$sub_input_group.'\')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}