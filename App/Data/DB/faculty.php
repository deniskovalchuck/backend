<?php

namespace App\Data\DB;
use Core\Database\Database;

class Faculty{
    public static function get_all_faclties(Database $connection){
        $result = $connection->query('SELECT * FROM get_teachers_in_faculty()');
        while($row = pg_fetch_assoc($result)){
            $teacher_array = [
                'name_faculties' => $row['name_faculties'],
                'logo_faculty' => $row['logo_faculty'],
            ];
        }
        return $teacher_array;
    }

    public static function add_faculty(Database $connection, $name_input_faculty, $logo_input_faculty){
        $result = $connection->query('SELECT * FROM add_faculty('.$name_input_faculty.', '.$logo_input_faculty.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }

    public static function delete_faculty(Database $connection, $name_faculty_for_delete){
        $result = $connection->query('SELECT * FROM delete_faculty('.$name_faculty_for_delete.')');
        $arr = pg_fetch_all($result);
        return $arr;
    }
}