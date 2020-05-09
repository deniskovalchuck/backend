<?php

namespace App\Http\Controllers;

use App\Data\DB\Education;
use Core\helpers\Config;
use Core\helpers\Response;

class EducationController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public  function add_education_type(){
        $response = new Response();
        if( isset($_POST['name_input_education_type']))
        {
            try {
                $data = Education::add_education_type($this->link,$_POST['name_input_education_type']);
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
    public  function delete_education_type(){
        $response = new Response();
        if(isset($_POST['name_input_education_type']))
        {
            try {
                $data = Education::delete_education_type($this->link,$_POST['name_input_education_type']);
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

    public  function get_all_education_type(){
        $response = new Response();
        try {
            $data = Education::get_all_education_type($this->link);
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
