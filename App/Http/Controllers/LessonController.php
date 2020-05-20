<?php

namespace App\Http\Controllers;

use App\Data\DB\Lesson;
use Core\helpers\Config;
use Core\helpers\Response;

class LessonController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }
    /*return integer (-1 - error)*/
    public function get_id_lesson(){
        $response = new Response();
        if( isset($_POST['name_input_type_lesson'])
            && isset($_POST['name_input_type_education'])
            && isset($_POST['name_input_payment_type'])
            && isset($_POST['num_input_lesson'])
            && isset($_POST['week_input_day'])
            && isset($_POST['week_input_type'])
            && isset($_POST['start_input_date'])
            && isset($_POST['end_input_date'])
        )
        {
            try {
                $data = Lesson::get_id_lesson($this->link,$_POST['name_input_type_lesson']
                    , $_POST['name_input_type_education']
                    , $_POST['name_input_payment_type']
                    , $_POST['num_input_lesson']
                    , $_POST['week_input_day']
                    , $_POST['week_input_type']
                    , $_POST['start_input_date']
                    , $_POST['end_input_date']);
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

    /*return integer (-1 - error)*/
    public function add_lesson(){
        $response = new Response();
        if( isset($_POST['name_input_type_lesson'])
            && isset($_POST['name_input_education_type'])
            && isset($_POST['name_input_payment_type'])
            && isset($_POST['week_input_type'])//
            && isset($_POST['week_input_day'])//
            && isset($_POST['num_input_lesson'])//
            && isset($_POST['subject_name'])//
            && isset($_POST['groups'])//
            && isset($_POST['teachers'])//
        )
        {
            try {
                $data = Lesson::add_lesson($this->link,$_POST['name_input_type_lesson']
                    ,$_POST['name_input_education_type']
                    ,$_POST['name_input_payment_type']
                    ,$_POST['week_input_type']
                    ,$_POST['week_input_day']
                    ,$_POST['num_input_lesson'],$_POST['subject_name']);
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

    /*return string ('Запись успешно удалена!', 'Занятия нет в базе!')*/
    public function delete_lesson(){
        $response = new Response();
        if( isset($_POST['id_input_lesson']))
        {
            try {
                $data = Lesson::delete_lesson($this->link,$_POST['id_input_lesson']);
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

    public function get_all_type_lesson(){
        $response = new Response();

            try {
                $data = Lesson::get_all_type_lesson($this->link);
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

    public function get_all_lessons(){
        $response = new Response();
        if( isset($_POST['name_input_education_type']))
        {
            try {
                $data = Lesson::get_all_lessons($this->link);
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

    public  function get_all_lessons_by_group(){
        $response = new Response();
        if( isset($_POST['abbrevation_input_group'])
        && isset($_POST['year_entry_input'])
            && isset($_POST['name_faculty_input'])
            && isset($_POST['name_department_input'])
            && isset($_POST['name_specialization_input'])
            && isset($_POST['education_type_input'])
            && isset($_POST['sub_input_group'])
        )
        {
            try {
                $data = Lesson::get_all_lessons_by_group($this->link,$_POST['abbrevation_input_group']
                    , $_POST['year_entry_input']
                    , $_POST['name_faculty_input']
                    , $_POST['name_department_input']
                    , $_POST['name_specialization_input']
                    , $_POST['education_type_input']
                    , $_POST['sub_input_group']);
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

    public function get_all_lessons_by_teacher(){
        $response = new Response();

        if( isset($_POST['login_input_teacher']))
        {
            try {
                $data = Lesson::get_all_lessons_by_teacher($this->link,$_POST['login_input_teacher']);
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
