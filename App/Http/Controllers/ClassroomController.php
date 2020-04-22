<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use Core\helpers\Config;

class ClassroomController {

    public  function get_all_bulding(){
        $data = null;
        $link = Config::get('app.database.connection');
        try {
            $data = Classrooms::get_all_bulding($link);
        }
        catch (\Exception $exception)
        {

        }
        $data = Classrooms::get_all_bulding($link);
        if(!$data)
            return json_encode(array());
        return json_encode($data);
    }

    public  function get_all_classrooms(){
        $link = Config::get('app.database.data');
        $data = Classrooms::get_all_classrooms($link);
        if(!$data)
            return json_encode(array());
        return json_encode($data);

    }

    public  function get_all_classrooms_in_building(){
        return 1;

    }

    public  function add_classroom(){
        return 1;

    }

    public  function delete_building(){
        return 1;

    }

    public  function delete_classroom(){
        return 1;

    }

}
