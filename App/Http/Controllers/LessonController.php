<?php

namespace App\Http\Controllers;

use App\Data\DB\Lesson;
use App\Data\DB\Teacher;
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
                    , $_POST['week_input_type']);
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
        if(
               isset($_POST['number_lesson'])//Введите номер пары
            && isset($_POST['subject_name'])//Выберите предмет
            && isset($_POST['payment_type'])//Выберите тип оплаты
            && isset($_POST['lesson_type'])//Выберите тип предмета
            && isset($_POST['lesson_type_name'])//Выберите название типа предмета
            && isset($_POST['day'])//Выберите день недели
            && isset($_POST['top_or_bottom_week'])//Выберите верхнюю или нижнюю неделю
            && isset($_POST['selected_groups'])//список групп
            && isset($_POST['selected_teachers'])//список преподователей
        )
        {
            if($_POST['top_or_bottom_week']=="ALL")
            {
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],'В',
                    $_POST['selected_groups'],$_POST['selected_teachers']);
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],'Н',
                    $_POST['selected_groups'],$_POST['selected_teachers']);
            }else
            {
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],$_POST['top_or_bottom_week'],
                    $_POST['selected_groups'],$_POST['selected_teachers']);
            }
            $response->set('result','success');
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



    private function addlesson($number_lesson,$subject_name,$payment_type,$lesson_type,
                               $lesson_type_name,$day,$top_or_bottom_week,$selected_groups,$selected_teachers){
        try {
            $data = Lesson::add_lesson($this->link,$lesson_type_name,$payment_type,$day,$top_or_bottom_week,
            $number_lesson,$subject_name);
            if($data!=null)
            {
                foreach ($selected_teachers as $item)
                {
                    $datateacher = Teacher::get_teacher_login($this->link,$item['step3_selected_teachers'][0],$item['step3_selected_teachers'][1],$item['step3_selected_teachers'][2],
                        $item['step3_selected_faculty'],$item['step3_selected_department']);

                    Lesson::add_teachers_on_lesson($this->link,$datateacher[0]['get_teacher_login'],$data[0]['add_lesson']);
                }
                foreach ($selected_groups as $item)
                {
                    Lesson::add_groups_on_lesson($this->link,$data[0]['add_lesson'],$item['step2_selected_groups'][0],$item['step2_selected_groups'][1],
                        $item['step2_selected_faculty'],
                    $item['step2_selected_department'],$item['step2_selected_special'],$item['step2_selected_groups'][2]);
                }
            }
        }
        catch (\Exception $exception)
        {
            var_dump($exception->getMessage());
            return $exception;
        }
    }
}
