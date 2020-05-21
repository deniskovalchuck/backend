<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use App\Data\DB\Groups;
use App\Data\DB\Lesson;
use App\Data\DB\Subjects;
use App\Data\DB\Teacher;
use App\Data\DB\Type_Lesson;
use App\Data\DB\Week;
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
            && isset($_POST['id_classroom'])
        )
        {
            try {
                $data = Lesson::get_id_lesson($this->link,$_POST['name_input_type_lesson']
                    , $_POST['name_input_type_education']
                    , $_POST['name_input_payment_type']
                    , $_POST['num_input_lesson']
                    , $_POST['week_input_day']
                    , $_POST['week_input_type'],$_POST['id_classroom']);
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
               && isset($_POST['housing'])//список преподователей
               && isset($_POST['class'])//список преподователей

        )
        {
            if($_POST['top_or_bottom_week']=="ALL")
            {
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],'В',
                    $_POST['selected_groups'],$_POST['selected_teachers'],$_POST['housing'],$_POST['class']);
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],'Н',
                    $_POST['selected_groups'],$_POST['selected_teachers'],$_POST['housing'],$_POST['class']);
            }else
            {
                $this->addlesson($_POST['number_lesson'],$_POST['subject_name'],
                    $_POST['payment_type'],$_POST['lesson_type'],
                    $_POST['lesson_type_name'],$_POST['day'],$_POST['top_or_bottom_week'],
                    $_POST['selected_groups'],$_POST['selected_teachers'],$_POST['housing'],$_POST['class']);
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
/*
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
*/
    public function get_all_lessons(){
        $response = new Response();
        if( isset($_POST['name_input_education_type']))
        {
            try {
                $data = Lesson::get_all_lessons($this->link);
                if($data) {
                    $timetable_Data = $this->generation_timetable($data);
                    $response->set('data',$timetable_Data);
                    $response->set('result','success');

                }
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
                if($data) {
                    $timetable_Data = $this->generation_timetable($data);
                    $result=array();
                    if($timetable_Data!=null)
                        //по строкам
                    for($i=1;$i<$timetable_Data['max_num_lesson']+1;$i++)
                    {
                        $result[$i-1]=array();
                        //по столбцам
                         $key="Понедельник";
                            if(array_key_exists($i,$timetable_Data[$key]))
                            {
                                $result[$i-1][$key]=$timetable_Data[$key][$i];
                            }
                            else
                            {
                                $result[$i-1][$key]=null;
                            }
                        $key="Вторник";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                        $key="Среда";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                        $key="Четверг";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                        $key="Пятница";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                        $key="Суббота";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                        $key="Воскресенье";
                        if(array_key_exists($i,$timetable_Data[$key]))
                        {
                            $result[$i-1][$key]=$timetable_Data[$key][$i];
                        }
                        else
                        {
                            $result[$i-1][$key]=null;
                        }
                    }


                    $response->set('data',$result);
                    $response->set('result','success');

                }
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
                               $lesson_type_name,$day,$top_or_bottom_week,$selected_groups,$selected_teachers,$num_building,$num_class){
        try {
            $data = Lesson::add_lesson($this->link,$lesson_type_name,$payment_type,$day,$top_or_bottom_week,
            $number_lesson,$subject_name,$num_building,$num_class);

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


    private function generation_timetable($timetable_source){
        $timetable_data = array();
        $data = Week::get_all_week($this->link);
        if(!$data)
            return $timetable_data;

            $days=array();
            for($i=0;$i<count($data);$i++)
            {
                $days[$i]=$data[$i]['input_week_day'];
            }
            $days = array_unique($days);
            //сделали массив с днями недель
            foreach ($days as $item)
            {
                $timetable_data[$item]=array();
            }
            //обрабатываем данные
        //максимальная по номеру пара
        $timetable_data['max_num_lesson']=1;
        foreach ($timetable_source as $item)
        {
            if($item['num_lesson']> $timetable_data['max_num_lesson'])
                $timetable_data['max_num_lesson']=$item['num_lesson'];
            if(!array_key_exists($item['num_lesson'],$timetable_data[$item['week_day']]))
                $timetable_data[$item['week_day']][$item['num_lesson']]=array();


            //получаем название предмета
            $subject_data=Subjects::get_teacher_subjects_by_id($this->link,$item['id_subject_on_lesson']);
            if($subject_data)
            {
                //получили название предмета
                $subject_name=$subject_data[0]['get_teacher_subjects_by_id'];
                //создали ключи
                if(!array_key_exists($subject_name.'#'.$item['week_day_type'],$timetable_data[$item['week_day']][$item['num_lesson']])) {
                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']] = array();
                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['name'] =$subject_name;
                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['week_day_type'] =$item['week_day_type'];

                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['groups']=array();
                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['teachers']=array();
                }
                $groupdata= Groups::get_groups_by_id($this->link,$item['id_groups_on_lesson']);
                if($groupdata)
                {
                    foreach ($groupdata as $group)
                    {
                        array_push($timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['groups'],
                        $group['abr_group'].$group['year_entry_group'].$group['subgroup']);
                    }
                    //дописать получениее аудитории
                    $d = Classrooms::get_num_building_and_class_by_ID($this->link,$item['id_classroom']);
                    if($d)
                    $timetable_data[$item['week_day']][$item['num_lesson']][$subject_name.'#'.$item['week_day_type']]['classroom']=$d;
                }
                else
                    return array();

            }
        }

        return $timetable_data;
    }

}
