<?php

namespace App\Http\Controllers;

use App\Data\DB\Position;
use Core\helpers\Config;
use Core\helpers\Response;

class PositionController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }
    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public  function add_position(){
        $response = new Response();
        if(isset($_POST['name_input_position']))
        {
            try {
                $data = Position::add_position($this->link,$_POST['name_input_position']);
                if(!$data)
                    $response->set('data',array());
                else
                    $response->set('data',$data);
                $response->set('result','success');
            }
            catch (\Exception $exception)
            {
                $response->set('error_code',$exception->getMessage());
            }
        }
        else
        {
            //вернуть код ошибки, что не переданы необходимые данные
        }
        return $response->makeJson();
    }

    /*return string ('Запись успешно удалена!', 'Записи нет в базе!')*/
    public  function delete_teacher_position(){
        $response = new Response();
        if(isset($_POST['name_teacher_position']))
        {
            try {
                $data = Position::delete_teacher_position($this->link,$_POST['name_teacher_position']);
                if(!$data)
                    $response->set('data',array());
                else
                    $response->set('data',$data);
                $response->set('result','success');
            }
            catch (\Exception $exception)
            {
                $response->set('error_code',$exception->getMessage());
            }
        }
        else
        {
            //вернуть код ошибки, что не переданы необходимые данные
        }
        return $response->makeJson();
    }

    public  function get_all_teacher_positions(){
        $response = new Response();

            try {
                $data = Position::get_all_teacher_positions($this->link);
                if(!$data)
                    $response->set('data',array());
                else
                    $response->set('data',$data);
                $response->set('result','success');
            }
            catch (\Exception $exception)
            {
                $response->set('error_code',$exception->getMessage());
            }

        return $response->makeJson();
    }
}
