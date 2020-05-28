<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use App\Data\DB\Lesson;
use App\Data\DB\Positions;
use App\Data\DB\Substitution;
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
        if(isset($_POST['name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['login_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher'])
            && isset($_POST['name_position_input_teacher'])
            && isset($_POST['photo_input_teacher'])
        )
        {
            try {
                $data = Teacher::add_teacher($this->link,$_POST['name_input_teacher']
                    ,$_POST['second_name_input_teacher']
                    ,$_POST['third_name_input_teacher']
                    ,$_POST['login_input_teacher']
                    ,$_POST['name_faculty_input_teacher']
                    ,$_POST['name_department_input_teacher']
                    ,$_POST['name_position_input_teacher']
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


                $datas=Positions::get_position_by_id($this->link, $_POST['name_position_input_teacher']);
                if(is_array($datas))
                $_POST['name_position_input_teacher']=$datas[0]['get_position_by_id'];
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
        if(isset($_POST['name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher']))
        {
            try {
                $data = Teacher::get_teacher_info($this->link,$_POST['name_input_teacher']
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


    //переносы
    public  function create_sub_for_teacher( ){
        $response = new Response();

        if( isset($_POST['login_input_teacher'])
            &&isset($_POST['date_from_sub_teacher'])
            && isset($_POST['date_to_sub_teacher'])
            && isset($_POST['id_input_lesson'])
            && isset($_POST['num_input_building'])
            && isset($_POST['num_input_class'])
            && isset($_POST['name_input_teacher'])
            && isset($_POST['second_name_input_teacher'])
            && isset($_POST['third_name_input_teacher'])
            && isset($_POST['name_faculty_input_teacher'])
            && isset($_POST['name_department_input_teacher'])
            && isset($_POST['num_input_lesson'])
        )
        {
            try {
                $login_input_replaceable_teacher=$_POST['login_input_teacher'];
                $data = Teacher::get_teacher_login($this->link,$_POST['name_input_teacher']
                    , $_POST['second_name_input_teacher']
                    , $_POST['third_name_input_teacher']
                    , $_POST['name_faculty_input_teacher']
                    , $_POST['name_department_input_teacher']);
                if(!$data)
                    return $response->makeJson();


                $data = Substitution::create_sub_for_teacher($this->link,$login_input_replaceable_teacher
                    , $data[0]['get_teacher_login']
                    , $_POST['date_from_sub_teacher']
                    , $_POST['date_to_sub_teacher']
                    , $_POST['id_input_lesson']
                    , $_POST['num_input_building']
                    , $_POST['num_input_class']
                    , $_POST['num_input_lesson']);
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
            && isset($_POST['login_input_replacing_teacher'])
            && isset($_POST['date_from_sub_teacher'])
            && isset($_POST['date_to_sub_teacher'])
            && isset($_POST['id_input_lesson'])
            && isset($_POST['num_input_building'])
            && isset($_POST['num_input_class'])
            && isset($_POST['num_input_lesson'])
        )
        {
            try {
                $data = Substitution::delete_sub_for_teacher($this->link, $_POST['login_replaceable_teacher'],
                $_POST['login_input_replacing_teacher'],
                    $_POST['date_to_sub_teacher'],
                    $_POST['date_from_sub_teacher'], $_POST['id_input_lesson'],
               $_POST['num_input_building'], $_POST['num_input_class'], $_POST['num_input_lesson']);
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
    public  function get_all_sub_for_teacher( ){
        $response = new Response();
        if(isset($_POST['login_replaceable_teacher']))
        try {
                $data = Substitution::get_all_sub_by_teacher($this->link,$_POST['login_replaceable_teacher']);
                if(!$data)
                    $response->set('data',array());
                else
                {
                    $result=array();
                    try {
                        for ($i=0;$i<count($data);$i++)
                        {
                            $result[$i]=array();
                            $result[$i]['date_from']=$data[$i]['date_from'];
                            $result[$i]['date_sub']=$data[$i]['date_sub'];
                            $result[$i]['id_lesson']=$data[$i]['id_lesson'];
                            $result[$i]['num_lesson']=$data[$i]['num_lesson'];
                            $teacher_data = Teacher::get_tacher_by_id($this->link,$data[$i]['id_teacher']);
                            $teacher_data_new = Teacher::get_tacher_by_id($this->link,$data[$i]['id_new_teacher']);
                            $result[$i]['teacher']=array();
                            $result[$i]['teacher']['login']=$teacher_data[0]['login_teacher'];
                            $result[$i]['teacher']['FIO']=$teacher_data[0]['name_teacher'].' '.$teacher_data[0]['second_name_teacher'].' '.$teacher_data[0]['third_name_teacher'];
                            $result[$i]['newteacher']=array();
                            $result[$i]['newteacher']['login']=$teacher_data_new[0]['login_teacher'];
                            $result[$i]['newteacher']['FIO']=$teacher_data_new[0]['name_teacher'].' '.$teacher_data_new[0]['second_name_teacher'].' '.$teacher_data_new[0]['third_name_teacher'];
                            $result[$i]['classrooms']=Classrooms::get_num_building_and_class_by_ID($this->link,$data[$i]['id_classroom']);
                            $result[$i]['lesson_data']=Lesson::get_lesson_by_id($this->link, $data[$i]['id_lesson'])[0];

                        }
                        $response->set('data',$result);

                    }
                    catch (\Exception $ex)
                    {
                        $response->set('error_code',$ex->getMessage());

                    }
                }
                $response->set('result','success');
            }
            catch (\Exception $exception)
            {
                $response->set('error_code',$exception->getMessage());
            }

        return $response->makeJson();
    }

}
