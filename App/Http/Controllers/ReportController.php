<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use App\Data\DB\Groups;
use App\Data\DB\Teacher;
use App\Data\DB\Type_Lesson;
use Core\helpers\Config;
use Core\helpers\Response;

class ReportController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

   private static function cmp($a, $b)
    {
        if ($a["date"] == $b["date"]) {
            return 0;
        }
        return (strtotime($a["date"]) < strtotime($b["date"])) ? -1 : 1;
    }
    public  function create_report(){
        $response = new Response();
        if(isset($_POST['payment_type']) && isset($_POST['step3_selected_faculty'])
            && isset($_POST['step3_selected_department'])&& isset($_POST['step3_selected_teachers'])
            && isset($_POST['monts']) )
        {
            try {
                $name=explode('#',$_POST['step3_selected_teachers']);
                $data = array();
                $type_lesson = Type_Lesson::get_all_type_lesson($this->link);
                $k=0;
                $teacher = Teacher::get_teacher_login($this->link,$name[0]
                    , $name[1]
                    , $name[2]
                    , $_POST['step3_selected_faculty']
                    , $_POST['step3_selected_department']);

                for($i=0;$i<count($type_lesson);$i++)
                {

                    $report=Teacher::generation_report($this->link,$teacher[0]['get_teacher_login'],
                        $_POST['monts'],$type_lesson[$i]['type_lessons'],
                        $_POST['payment_type']);
                    for($j=0;$j<count($report);$j++)
                    {
                        $data[$k]=array();
                        $data[$k]['type']=$type_lesson[$i]['type_lessons'];
                        $data[$k]['date']=$report[$j]['Date'];
                        $data[$k]['count_hour']=$report[$j]['count_hour'];
                        $group = Groups::get_groups_by_id($this->link,$report[$j]['id_students_groups']);
                        $data[$k]['group']=$group[0]['abr_group'].'-'.$group[0]['year_entry_group'].$group[0]['subgroup'];
                        $k++;
                    }
                    var_dump($report);
                }
                $response->set('data2',$data);

                usort($data, array($this,'cmp'));
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
