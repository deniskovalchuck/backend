<?php

namespace App\Http\Controllers;

use App\Data\DB\Teacher;
use Core\helpers\Config;
use Core\helpers\Response;

class TeacherController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }
    public  function get_teacher_by_login(){
        $response = new Response();
        if(isset($_POST['teacher_login']))
        {
            try {
                $data = Teacher::get_teacher_by_login($this->link,$_POST['teacher_login']);
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

    public  function get_teachers_in_faculty(){
        $response = new Response();
        if(isset($_POST['teacher_faculty_name']))
        {
            try {
                $data = Teacher::get_teachers_in_faculty($this->link,$_POST['teacher_faculty_name']);
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

    public  function get_teachers_in_department(){
        $response = new Response();
        if(isset($_POST['teacher_faculty_name']) && isset($_POST['teacher_department_name']))
        {
            try {
                $data = Teacher::get_teachers_in_department($this->link,$_POST['teacher_faculty_name'], $_POST['teacher_department_name']);
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

    /*return string ('Факультета не существует!', 'Кафедры не существует!', 'Должности не существует!', 'Логин не уникален!', 'Запись уже существует!', 'Запись добавлена!')*/
    public  function add_teacher(){
        $response = new Response();
        if(isset($_POST['$name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['login_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher'])
            && isset($_POST['name_position_input_teacher'])
            && isset($_POST['input_email'])
            && isset($_POST['photo_input_teacher'])
        )
        {
            try {
                $data = Teacher::add_teacher($this->link,$_POST['$name_input_teacher']
                    ,$_POST['second_name_input_teacher']
                    ,$_POST['third_name_input_teacher']
                    ,$_POST['login_input_teacher']
                    ,$_POST['name_faculty_input_teacher']
                    ,$_POST['name_department_input_teacher']
                    ,$_POST['name_position_input_teacher']
                    ,$_POST['input_email']
                    ,$_POST['photo_input_teacher']);
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

    /*return string ('Запись успешно удалена!', 'Записи не существует!')*/
    public  function delete_teacher(){
        $response = new Response();
        if(isset($_POST['name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher'])
            && isset($_POST['name_position_input_teacher'])

        )
        {
            try {
                $data = Teacher::delete_teacher($this->link,$_POST['name_input_teacher']
                    , $_POST['second_name_input_teacher']
                    , $_POST['third_name_input_teacher']
                    , $_POST['name_faculty_input_teacher']
                    , $_POST['name_department_input_teacher']
                    , $_POST['name_position_input_teacher']);
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

    public  function get_teacher_info(){
        $response = new Response();
        if(isset($_POST['$name_input_teacher'])
            && isset($_POST['$second_name_input_teacher'])
            && isset($_POST['$third_name_input_teacher'])
            && isset($_POST['$name_faculty_input_teacher'])
            && isset($_POST['$name_department_input_teacher'])
            && isset($_POST['$name_position_input_teacher'])

        )
        {
            try {
                $data = Teacher::get_teacher_info($this->link,$_POST['$name_input_teacher']
                    , $_POST['$second_name_input_teacher']
                    , $_POST['$third_name_input_teacher']
                    , $_POST['$name_faculty_input_teacher']
                    , $_POST['$name_department_input_teacher']
                    , $_POST['$name_position_input_teacher']);
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

    public  function get_teacher_login(){
        $response = new Response();
        if(isset($_POST['name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher'])
        )
        {
            try {
                $data = Teacher::get_teacher_login($this->link,$_POST['name_input_teacher']
                    , $_POST['second_name_input_teacher']
                    , $_POST['third_name_input_teacher']
                    , $_POST['name_faculty_input_teacher']
                    , $_POST['name_department_input_teacher']);
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

    public  function create_sub_for_teacher( ){
        $response = new Response();
        if(isset($_POST['login_replaceable_teacher'])
            && isset($_POST['login_replacing_teacher'])
            && isset($_POST['date_sub_teacher'])
        )
        {
            try {
                $data = Teacher::create_sub_for_teacher($this->link,$_POST['login_replaceable_teacher']
                    , $_POST['login_replacing_teacher']
                    , $_POST['date_sub_teacher']);
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

    public  function delete_sub_for_teacher( ){
        $response = new Response();
        if(isset($_POST['login_replaceable_teacher'])
            && isset($_POST['login_replacing_teacher'])
            && isset($_POST['date_sub_teacher'])
        )
        {
            try {
                $data = Teacher::delete_sub_for_teacher($this->link,$_POST['login_replaceable_teacher']
                    , $_POST['login_replacing_teacher']
                    , $_POST['date_sub_teacher']);
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
                $data = Teacher::get_all_teacher_positions($this->link);
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
