<?php

namespace App\Http\Controllers;

use App\Data\DB\Subjects;
use Core\helpers\Config;
use Core\helpers\Response;

class SubjectController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    public function get_all_subjects(){
        $response = new Response();

            try {
                $data = Subjects::get_all_subjects($this->link);
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

    public  function add_subject(){
        $response = new Response();
        if(isset($_POST['name_input_subject']))
        {
            try {
                $data = Subjects::add_subject($this->link,$_POST['name_input_subject']);
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

    public  function delete_subject(){
        $response = new Response();
        if(isset($_POST['name_input_subject']))
        {
            try {
                $data = Subjects::delete_subject($this->link,$_POST['name_input_subject']);
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

    //предметы, которые может вести препод
    public  function get_teacher_subjects(){
        $response = new Response();
        if(isset($_POST['login_input_teacher']))
        {
            try {
                $data = Subjects::get_teacher_subjects($this->link,$_POST['login_input_teacher']);
                if(!$data)
                    $response->set('data',array());
                else
                {
                    $new_data=array();
                    for($i=0;$i<count($data);$i++)
                    {
                        $new_data[$i]=array();
                        $new_data[$i]['teacher_subject']=Subjects::get_teacher_subjects_by_id($this->link,$data[$i]['teacher_subject'])[0]['get_teacher_subjects_by_id'];
                    }
                    $response->set('data',$new_data);

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

    public  function add_teacher_subjects_by_FIO(){
        $response = new Response();
        if
        (
            isset($_POST['name_input_teacher']) &&
            isset($_POST['second_input_name_teacher']) &&
            isset($_POST['third_input_name_teacher']) &&
            isset($_POST['name_subject'])
        )
        {
            try {
                $data = Subjects::add_teacher_subjects_by_FIO($this->link,$_POST['name_input_teacher'] ,
                    $_POST['second_input_name_teacher'] ,
                    $_POST['third_input_name_teacher'] ,
                    $_POST['name_subject']);
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

    public  function add_teacher_subjects_by_login(){
        $response = new Response();
        if(isset($_POST['login_input_teacher'])
            && isset($_POST['name_input_subject'])
        )
        {
            try {
                $data = Subjects::add_teacher_subjects_by_login($this->link,$_POST['login_input_teacher'],$_POST['name_input_subject']);
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

    /*return string ('Преподавателя не существует!', 'Предмета не существует!', 'Запись успешно удалена!')*/
    public  function delete_teacher_subjects(){
        $response = new Response();
        if(isset($_POST['login_input_teacher'])
            && isset($_POST['name_input_subject'])
        )
        {
            try {
                $data = Subjects::delete_teacher_subjects($this->link,$_POST['login_input_teacher'],$_POST['name_input_subject']);
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
