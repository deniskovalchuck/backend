<?php

namespace App\Http\Controllers;

use App\Data\DB\Type_Lesson;
use Core\helpers\Config;
use Core\helpers\Response;

class TypeOfActivityController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    public  function get_all(){
        $response = new Response();
        try {
            $data = Type_Lesson::get_all_type_lesson($this->link);
            if(!$data)
                $response->set('data',array());
            else
            {
                for($i=0;$i<count($data);$i++)
                {
                    if($data[$i]['name_type_education']=='О')
                    {
                        $data[$i]['name_type_education']='Обучение';
                    }
                    else
                    {
                        $data[$i]['name_type_education']='Сессия';

                    }
                }
                $response->set('data',$data);
            }
            $response->set('result','success');
        }
        catch (\Exception $exception)
        {
            $response->set('error_code',$exception->getMessage());
        }
        return $response->makeJson();
    }

    public  function get_all_by_type(){
        $response = new Response();
        if(isset($_POST['type']))
        {
            try {
                $data = Type_Lesson::get_all_type_lesson_by_name_type_education($this->link,$_POST['type']);
                if(!$data)
                    $response->set('data',array());
                else
                {

                    $response->set('data',$data);
                }
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
    public  function delete(){
        $response = new Response();
        if(isset($_POST['input_name_type_lesson']) & isset($_POST['input_type_education']))
        {
            if($_POST['input_type_education']=='Обучение') $_POST['input_type_education']='О';
            else
                $_POST['input_type_education']='С';
            try {
                $data = Type_Lesson::delete_type_lesson($this->link,$_POST['input_name_type_lesson'],$_POST['input_type_education']);
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
    public  function add(){
        $response = new Response();
        if(isset($_POST['input_name_type_lesson']) & isset($_POST['input_type_education']))
        {
            try {
                $data = Type_Lesson::add_type_lesson($this->link,$_POST['input_name_type_lesson'],$_POST['input_type_education']);
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

}
