<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use App\Data\DB\Groups;
use App\Data\DB\Teacher;
use App\Data\DB\Type_Lesson;
use Core\helpers\Config;
use Core\helpers\Response;
use Core\PhpSpreadsheet\Spreadsheet;
use Core\PhpSpreadsheet\Style\Alignment;
use Core\PhpSpreadsheet\Style\Border;
use Core\PhpSpreadsheet\Writer\Xlsx;
use Core\PhpSpreadsheet\Worksheet\Worksheet;

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
            && isset($_POST['type']) )
        {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $name=explode('#',$_POST['step3_selected_teachers']);
            $type_lesson = Type_Lesson::get_all_type_lesson($this->link);
            $teacher = Teacher::get_teacher_login($this->link,$name[0]
                , $name[1]
                , $name[2]
                , $_POST['step3_selected_faculty']
                , $_POST['step3_selected_department']);
            if($_POST['type']=='semestr')
            {

                $month = $this->get_months($_POST['monts'],$_POST['year']);
                for($i=0;$i<count($month);$i++)
                {
                    $spreadsheet->createSheet($i);
                    $sheet = $spreadsheet->getSheet($i);
                    $sheet = $this->generate_report_by_data($sheet,$type_lesson,$teacher,$name,$month[$i],$_POST['payment_type']);

                }
            }
            else
            {
                $sheet = $spreadsheet->getActiveSheet();
                $sheet = $this->generate_report_by_data($sheet,$type_lesson,$teacher,$name,$_POST['monts'],$_POST['payment_type']);
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


    private function generate_report_by_data(Worksheet $sheet,$type_lesson,$teacher,$name,$monts,$payment_type)
    {
        $data = array();
        $k=0;
        for($i=0;$i<count($type_lesson);$i++)
        {

            $report=Teacher::generation_report($this->link,$teacher[0]['get_teacher_login'],
                $monts,$type_lesson[$i]['type_lessons'],
                $payment_type);
            for($j=0;$j<count($report);$j++)
            {
                $data[$k]=array();
                $data[$k]['type']=$type_lesson[$i]['type_lessons'];
                $data[$k]['date']=$report[$j]['Date'];
                $data[$k]['num_lesson']=$report[$j]['num_lesson'];
                $data[$k]['count_hour']=$report[$j]['count_hour'];
                $group = Groups::get_groups_by_id($this->link,$report[$j]['id_students_groups']);
                $group[0]['year_entry_group']=  substr($group[0]['year_entry_group'], 2);

                $data[$k]['group']=$group[0]['abr_group'].'-'.$group[0]['year_entry_group'].$group[0]['subgroup'];
                $k++;
            }
        }

        /**********************генерация отчета******************************/
        $result_data=array();
        $unicle_dates=$this->unique_multidim_array($data,'date');
        for($i=0;$i<count($unicle_dates);$i++)
        {
            $result_data[$i]=array();
            //дата
            $result_data[$i]['date']=$unicle_dates[$i];


            /********************рабочий код************************ */
            $result_data[$i]['group']=array();

            $unicle_num_lesson=array();
            //ищем уникальные пары
            foreach ($data as $datum) {

                if(trim($datum['date'])===trim($result_data[$i]['date']))
                {

                    $exist=false;
                    foreach($unicle_num_lesson as $item)  
                    {
                        if($item===$datum['num_lesson'])
                        {
                            $exist=true;
                            break;
                        }
                    }                  
                    if($exist==false) array_push($unicle_num_lesson,$datum['num_lesson']);
                }
            }
            //идем по уникальным парам в определнный день для формирования строки с группами
            foreach($unicle_num_lesson as $item)
            {
                $group_name="";
                $type="";
                $count_hour=0;
                foreach ($data as $datum) {
                    if(trim($datum['date'])===trim($result_data[$i]['date']))
                    {
                        if($datum['num_lesson']==$item)
                        {
                            $group_name.=$datum['group'].', ';
                            $type=$datum['type'];
                            $count_hour=$datum['count_hour'];
                        }
                    }
                }
                $group_name.=' ';
                $group_name=str_replace(',  ','',$group_name);
                //заполняем часы для данной строки 
                if(!isset($result_data[$i]['group'][$group_name]))
                {
                    $result_data[$i]['group'][$group_name]=array();
                    for($j=0;$j<count($type_lesson);$j++)
                    {
                        $result_data[$i]['group'][$group_name][$type_lesson[$j]['type_lessons']]=0;

                    }
                }
                $result_data[$i]['group'][$group_name][$type]+=$count_hour;

            }

            /******************рабочий код************************ */


            /*
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

            }*/

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
        $_mD = date(".m.", strtotime($monts)); //для замены
        $currentDate = $_monthsList[$_mD];
        usort($result_data, array($this,'cmp'));
        $chars = range('A', 'Z');
        $start_index=2;

        $sheet->setTitle($currentDate);
        $iter='';
        if(count($type_lesson)+2+1>count($chars))
            $iter= 'A1:'.$chars[2+1].'1';
        else
            $iter= 'A1:'.$chars[count($type_lesson)+2].'1';
        $sheet->getColumnDimension('A')->setWidth(11);

        //название
        $sheet->mergeCells($iter);
        $sheet->setCellValue('A1','Фамилия, имя, отчество '. $name[1].' '.$name[0].' '. $name[2].' '.$payment_type);
        $sheet->getStyle($iter)->getAlignment()->setWrapText(true);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle($iter)->getFont()->setSize(12);
        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');

        /****************дата*************************/
        $sheet->mergeCells('A3:A4');
        $sheet->setCellValue('A3','Дата');
        $sheet->getStyle('A3:A4')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('A3:A4')
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle('A3:A4')
            ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A3:A4')
            ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle('A3:A4')
            ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A3:A4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A3:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:A4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:A4')->getFont()->setSize(9);
        $sheet->getStyle('A3:A4')->getFont()->setName('Times New Roman');

        //группа
        $sheet->mergeCells('B3:B4');
        $sheet->setCellValue('B3','Группа');
        $sheet->getStyle('B3:B4')
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle('B3:B4')
            ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('B3:B4')
            ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('B3:B4')
            ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('B3:B4')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('B3:B4')->getAlignment()->setWrapText(false);
        $sheet->getStyle('B3:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B3:B4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B3:B4')->getFont()->setSize(12);
        $sheet->getStyle('B3:B4')->getFont()->setName('Times New Roman');

        $iter='';
        if(count($type_lesson)+2+1>count($chars))
            $iter='C3:'.$chars[(count($type_lesson)+2)-count($chars)].'3';
        else
            $iter='C3:'.$chars[count($type_lesson)+2].'3';
        //виды занятий
        $sheet->mergeCells($iter);
        $sheet->setCellValue('C3','Виды занятий');
        $sheet->getStyle($iter)->getFont()->setSize(9);
        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');

        $sheet->getStyle($iter)
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle($iter)
            ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $iter=$chars[count($type_lesson)+2].'4';
        $sheet->getStyle($iter)
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue($chars[count($type_lesson)+2].'4','ИТОГО');
        $sheet->getStyle($iter)->getFont()->setSize(9);
        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');

        $sheet->getStyle($iter)->getAlignment()->setTextRotation(90);
        $sheet->getStyle($iter)->getAlignment()->setWrapText(true);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //вывод цифр
        for($i=0;$i<count($type_lesson)+3;$i++)
        {
            if($i>1)
                $sheet->setCellValue($chars[$i].'5',$i-1);
            $sheet->getStyle($chars[$i].'5')
                ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($chars[$i].'5')
                ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($chars[$i].'5')
                ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($chars[$i].'5')
                ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($chars[$i].'5')->getAlignment()->setWrapText(false);
            $sheet->getStyle($chars[$i].'5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($chars[$i].'5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($chars[$i].'5')->getFont()->setSize(9);
            $sheet->getStyle($chars[$i].'5')->getFont()->setName('Times New Roman');

        }
        $iter='';
        //вывод месяца
        if(count($type_lesson)+2>=count($chars))
            $iter='A6:'.$chars[(count($type_lesson)+2)-count($chars)].'6';
        else
            $iter='A6:'.$chars[count($type_lesson)+2].'6';
        $sheet->mergeCells($iter);
        $sheet->getStyle($iter)
            ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($iter)
            ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle($iter)
            ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
        $sheet->getStyle($iter)->getAlignment()->setWrapText(true);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->setCellValue('A6',$currentDate);
        $sheet->getStyle($iter)->getFont()->setSize(12);
        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');
        $sheet->getStyle($iter)->getFont()->setBold(true);
        //заполнение типы предметов
        for($j=0;$j<count($type_lesson);$j++)
        {
            //$iter=$chars[$start_index].'4:'.$chars[$start_index].'5';
           // $sheet->mergeCells($iter);
            $iter=$chars[$start_index].'4';
            $sheet->setCellValue($chars[$start_index].'4',$type_lesson[$j]['type_lessons']);
            $sheet->getStyle($iter)
                ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($iter)
                ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($iter)
                ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($iter)
                ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($chars[$start_index].'4')->getAlignment()->setTextRotation(90);
            $sheet->getStyle($iter)->getFont()->setSize(9);
            $sheet->getStyle($iter)->getFont()->setName('Times New Roman');

            $sheet->getStyle($chars[$start_index].'4')->getAlignment()->setWrapText(true);
            $sheet->getStyle($chars[$start_index].'4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($chars[$start_index].'4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $start_index++;
        }
        //заполняем данными отчет
        $start_row=7;
        foreach ($result_data as $result_datum) {
            foreach ($result_datum['group'] as $key=>$data)
            {
                //вывод даты
                $dates = explode('-',$result_datum['date']);
                $sheet->setCellValue('A'.$start_row,date('d.m.y',mktime(0, 0, 0, $dates[1], $dates[2], $dates[0])));
                $sheet->getStyle('A'.$start_row)->getAlignment()->setWrapText(true);
                $sheet->getStyle('A'.$start_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A'.$start_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$start_row)->getFont()->setSize(12);
                $sheet->getStyle('A'.$start_row)->getFont()->setName('Times New Roman');
                //вывод группы
                $sheet->setCellValue('B'.$start_row,$key);
                $sheet->getStyle('B'.$start_row)->getAlignment()->setWrapText(true);
                $sheet->getStyle('B'.$start_row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B'.$start_row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('B'.$start_row)->getFont()->setSize(12);
                $sheet->getStyle('B'.$start_row)->getFont()->setName('Times New Roman');

                foreach ($data as $type=>$typedata)
                {
                    if($typedata!=0)
                    {
                        //вывод часов
                        if(2+$this->get_index($type_lesson,$type)>=count($chars))
                            $iter=$chars[(2+$this->get_index($type_lesson,$type))-count($chars)].$start_row;
                        else
                            $iter=$chars[2+$this->get_index($type_lesson,$type)].$start_row;
                        $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
                        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $sheet->setCellValue($iter,
                            $typedata);
                        $sheet->getStyle($iter)->getFont()->setSize(12);
                        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');
                    }
                }
                $iter=$chars[count($type_lesson)+2].$start_row;
                //вывод формулы итого
                $iter2='C'.$start_row.':'.$chars[count($type_lesson)+1].$start_row;
                $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
                $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->setCellValue($iter,
                    '=SUM('.$iter2.')');
                $sheet->getStyle($iter)->getFont()->setSize(12);
                $sheet->getStyle($iter)->getFont()->setName('Times New Roman');

                //оформление границ для итого внизу
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
        $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
        $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($iter)->getFont()->setSize(12);
        $sheet->getStyle($iter)->getFont()->setName('Times New Roman');
        $sheet->getStyle($iter)->getFont()->setBold(true);

        //заполнение формул для итого
        for($j=0;$j<count($type_lesson)+1;$j++)
        {
            $iter=$chars[$j+2].$start_row;
            $iter2='=Sum('.$chars[$j+2].'7:'.$chars[$j+2].($start_row-1).')';
            $sheet->setCellValue($iter,$iter2);

            $sheet->getStyle($iter)
                ->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($iter)
                ->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($iter)
                ->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($iter)
                ->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);
            $sheet->getStyle($iter)->getAlignment()->setWrapText(false);
            $sheet->getStyle($iter)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($iter)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($iter)->getFont()->setSize(12);
            $sheet->getStyle($iter)->getFont()->setName('Times New Roman');
            $sheet->getStyle($iter)->getFont()->setBold(true);
        }
        return $sheet;
    }


    function get_months($semester_number, $year){
        $month_array = array();
        if ($semester_number == 1) {
            array_push($month_array, $year.'-09-01');
            array_push($month_array, $year.'-10-01');
            array_push($month_array, $year.'-11-01');
            array_push($month_array, $year.'-12-01');
            $year += 1;
            array_push($month_array, $year.'-01-01');
        }
        else {
            $year+=1;
            array_push($month_array, $year.'-02-01');
            array_push($month_array, $year.'-03-01');
            array_push($month_array, $year.'-04-01');
            array_push($month_array, $year.'-05-01');
            array_push($month_array, $year.'-06-01');
        }
        return $month_array;
    }

}
