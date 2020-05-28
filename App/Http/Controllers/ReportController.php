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

    public  function create_report(){
        $response = new Response();
        if(isset($_POST['login_input_teacher']) && isset($_POST['start_day_in_month'])
            && isset($_POST['name_input_payment_type']) )
        {
            try {
                $data = array();
                $type_lesson = Type_Lesson::get_all_type_lesson($this->link);
                $k=0;
                for($i=0;$i<count($type_lesson);$i++)
                {

                    $report=Teacher::generation_report($this->link,$_POST['login_input_teacher'],
                        $_POST['start_day_in_month'],$type_lesson[$i]['type_lessons'],
                        $_POST['name_input_payment_type']);
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

                }
                usort($data, "cmp");
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

    private function cmp($a, $b)
    {
        if ($a["date"] == $b["date"]) {
            return 0;
        }
        return (strtotime($a["date"]) < strtotime($b["date"])) ? -1 : 1;
    }

}
