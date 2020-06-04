<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use App\Data\DB\Groups;
use App\Data\DB\Teacher;
use App\Data\DB\Type_Lesson;
use Core\helpers\Config;
use Core\helpers\Response;
use Core\PhpSpreadsheet\Spreadsheet;
use Core\PhpSpreadsheet\Style\Border;
use Core\PhpSpreadsheet\Writer\Xlsx;

class ReportController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }


    public  function create_report(){
        $response = new Response();
        $teacher=null;
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
                }

                $result_data=array();
                $unicle_dates=$this->unique_multidim_array($data,'date');
                for($i=0;$i<count($unicle_dates);$i++)
                {
                    $result_data[$i]=array();
                    //дата
                    $result_data[$i]['date']=$unicle_dates[$i];

                    $result_data[$i]['group']=array();
                    foreach ($data as $datum) {
                        if(!isset($result_data[$i]['group'][$datum['group']]))
                        {
                            $result_data[$i]['group'][$datum['group']]=array();
                            for($j=0;$j<count($type_lesson);$j++)
                            {
                                $result_data[$i]['group'][$datum['group']][$type_lesson[$j]['type_lessons']]=0;

                            }
                        }
                        if(trim($datum['date'])===trim($result_data[$i]['date']))
                        $result_data[$i]['group'][$datum['group']][$datum['type']]+=$datum['count_hour'];

                    }

                }
                //список месяцев с названиями для замены
                $_monthsList = array(
                    ".01." => "Январь",
                    ".02." => "Февраль",
                    ".03." => "Март",
                    ".04." => "Апрель",
                    ".05." => "Май",
                    ".06." => "Июнь",
                    ".07." => "Июль",
                    ".08." => "Август",
                    ".09." => "Сентябрь",
                    ".10." => "Октябрь",
                    ".11." => "Ноябрь",
                    ".12." => "Декабрь"
                );
                $_mD = date(".m.", strtotime($_POST['monts'])); //для замены
                $currentDate = $_monthsList[$_mD];
                usort($result_data, array($this,'cmp'));
                $chars = range('A', 'Z');
                $start_index=2;

                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setTitle($currentDate);
                $iter='';
/*****************************************************/
                if(count($type_lesson)+2+1>count($chars))
                    $iter= 'A1:'.$chars[2+1].'1';
                else
                    $iter= 'A1:'.$chars[count($type_lesson)+2].'1';



                $sheet->mergeCells($iter);
                $sheet->setCellValue('A1','Фамилия, имя, отчество '. $name[1].' '.$name[0].' '. $name[2].' '.$_POST['payment_type']);

/*
                $sheet->getStyle($iter)
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
*/
                /*****************************************/
                $sheet->mergeCells('A3:A5');
                $sheet->setCellValue('A3','Дата');
                $sheet->getStyle('A3:A5')->getAlignment()->setTextRotation(90);

                $sheet->getStyle('A3:A5')
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle('A3:A5')
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A3:A5')
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle('A3:A5')
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                //$sheet->getStyle('A3:A5')->getAlignment()->setWrapText(true);

                $sheet->mergeCells('B3:B5');
                $sheet->setCellValue('B3','Группа');
                $sheet->getStyle('B3:B5')
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle('B3:B5')
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('B3:B5')
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('B3:B5')
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('B3:B5')->getAlignment()->setTextRotation(90);
                //$sheet->getStyle('B3:B5')->getAlignment()->setWrapText(true);

                $iter='';
                if(count($type_lesson)+2+1>count($chars))
                    $iter='C3:'.$chars[(count($type_lesson)+2)-count($chars)].'3';
                else
                    $iter='C3:'.$chars[count($type_lesson)+2].'3';

                $sheet->mergeCells($iter);

                $sheet->setCellValue('C3','Виды занятий');

                $sheet->getStyle($iter)
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);

                $iter=$chars[count($type_lesson)+2].'4:'.$chars[count($type_lesson)+2].'5';

                $sheet->mergeCells($iter);

                $sheet->getStyle($iter)
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);

                $sheet->setCellValue($chars[count($type_lesson)+2].'4','Итого');
                $sheet->getStyle($iter)->getAlignment()->setTextRotation(90);
                //$sheet->getStyle($iter)->getAlignment()->setWrapText(true);

                for($i=0;$i<count($type_lesson)+3;$i++)
                {
                    if($i>1)
                    $sheet->setCellValue($chars[$i].'6',$i-1);
                    $sheet->getStyle($chars[$i].'6')
                        ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($chars[$i].'6')
                        ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($chars[$i].'6')
                        ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($chars[$i].'6')
                        ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
                }
                $iter='';

                if(count($type_lesson)+2>=count($chars))
                    $iter='A7:'.$chars[(count($type_lesson)+2)-count($chars)].'7';
                else
                    $iter='A7:'.$chars[count($type_lesson)+2].'7';


                $sheet->mergeCells($iter);

                $sheet->getStyle($iter)
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle($iter)
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);

                $sheet->setCellValue('A7',$currentDate);


                for($j=0;$j<count($type_lesson);$j++)
                {
                    $iter=$chars[$start_index].'4:'.$chars[$start_index].'5';
                    $sheet->mergeCells($iter);
                    $sheet->setCellValue($chars[$start_index].'4',$type_lesson[$j]['type_lessons']);
                    $sheet->getStyle($iter)->getAlignment()->setTextRotation(90);
                    $sheet->getStyle($iter)->getAlignment()->setWrapText(true);

                    $sheet->getStyle($iter)
                        ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle($iter)
                        ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle($iter)
                        ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                    $sheet->getStyle($iter)
                        ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);

                    $start_index++;
                }
                //заполняем данными отчет
                $start_row=8;
                foreach ($result_data as $result_datum) {
                    foreach ($result_datum['group'] as $key=>$data)
                    {
                        $sheet->setCellValue('A'.$start_row,$result_datum['date']);
                        $sheet->setCellValue('B'.$start_row,$key);
                        foreach ($data as $type=>$typedata)
                        {
                            if($typedata!=0)
                            {
                                if(2+$this->get_index($type_lesson,$type)>=count($chars))
                                    $iter=$chars[(2+$this->get_index($type_lesson,$type))-count($chars)].$start_row;
                                else
                                    $iter=$chars[2+$this->get_index($type_lesson,$type)].$start_row;

                                $sheet->setCellValue($iter,
                                    $typedata);
                            }
                        }
                            $iter=$chars[count($type_lesson)+2].$start_row;

                        $iter2='C'.$start_row.':'.$chars[count($type_lesson)+1].$start_row;

                        $sheet->setCellValue($iter,
                            '=SUM('.$iter2.')');

                        for($j=0;$j<count($type_lesson)+3;$j++) {
                            $iter =$chars[$j] . $start_row;
                            $sheet->getStyle($iter)
                                ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                            $sheet->getStyle($iter)
                                ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                            if($j==0)
                                $sheet->getStyle($iter)
                                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                                else
                            $sheet->getStyle($iter)
                                ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
                            if($j==count($type_lesson)+2)
                                $sheet->getStyle($iter)
                                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
                            else
                            $sheet->getStyle($iter)
                                ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                        }
                        $start_row++;
                    }
                }
                $iter="A".$start_row.':'."B".$start_row;
                $sheet->mergeCells($iter);
                $sheet->setCellValue('A'.$start_row,'Итого');
                $sheet->getStyle($iter)
                    ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle($iter)
                    ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);


                for($j=0;$j<count($type_lesson)+1;$j++)
                {
                    $iter=$chars[$j+2].$start_row;
                    $iter2='=Sum('.$chars[$j+2].'8:'.$chars[$j+2].($start_row-1).')';
                    $sheet->setCellValue($iter,$iter2);

                    $sheet->getStyle($iter)
                        ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($iter)
                        ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($iter)
                        ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
                    $sheet->getStyle($iter)
                        ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
                }

                foreach($sheet->getRowDimensions() as $rowID) {
                    $rowID->setRowHeight(-1);
                }



                $writer = new Xlsx($spreadsheet);

                ob_start();
                $writer->save('php://output');
                $xlsData = ob_get_contents();
                ob_end_clean();
                $excelOutput= 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData);
                $response->set('file',$excelOutput);
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
    private function get_index($array,$key)
    {
        $index=0;
        foreach ($array as $k)
        {
            if($k['type_lessons']==$key)
                return $index;
            $index++;
        }
        return $index;
    }
    private function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        $data2='';
        foreach($array as $row)
        {
            $data2 .=', '.$row[$key];
        }
        $data3 = array_filter(explode(',', $data2));
        $result = array_unique($data3);
        foreach($result as $row)
        {
            $temp_array[$i]=$row;
            $i++;
        }

        return $temp_array;
    }
    private static function cmp($a, $b)
    {
        if ($a["date"] == $b["date"]) {
            return 0;
        }
        return (strtotime($a["date"]) < strtotime($b["date"])) ? -1 : 1;
    }

}
