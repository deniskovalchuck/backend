<?php
namespace App\Http\Controllers;

use App\Data\DB\Education;
use App\Data\DB\Groups;
use Core\helpers\Config;
use Core\helpers\Converter;
use Core\helpers\Response;
use App\Data\DB\Schedule;


class GroupController{

    var   $link = null;

    public function __construct()
    {
        $this->link = Config::get('app.database.connection');
    }

    public function add_students_groups()
    {
        $response = new Response();
        if(isset($_POST['abbrevation_input_group']) &
            isset($_POST['year_entry_input']) &
            isset($_POST['name_faculty_input']) &
            isset($_POST['name_department_input'])&
            isset($_POST['name_specialization_input'])&
            isset($_POST['education_type_input'])&
            isset($_POST['sub_input_group']))
        {
            try {
                $data = Groups::add_students_groups(
                    $this->link,
                    $_POST['abbrevation_input_group'],
                    $_POST['year_entry_input'],
                    $_POST['name_faculty_input'],
                    $_POST['name_department_input'],
                    $_POST['name_specialization_input'],
                    $_POST['education_type_input'],
                    $_POST['sub_input_group']
                );
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
    public function delete_student_groups()
    {
        $response = new Response();

        if(isset($_POST['abbrevation_input_group']) &
            isset($_POST['year_entry_input']) &
            isset($_POST['name_faculty_input']) &
            isset($_POST['name_department_input'])&
            isset($_POST['name_specialization_input'])&
            isset($_POST['education_type_input'])&
            isset($_POST['sub_input_group']))
        {
            try {
                $data=Education::get_name_education_type_by_id($this->link,$_POST['education_type_input']);

                    $_POST['education_type_input']=$data[0]['get_name_education_type_by_id'];
                $data = Groups::delete_student_groups(
                    $this->link,
                    $_POST['abbrevation_input_group'],
                    $_POST['year_entry_input'],
                    $_POST['name_faculty_input'],
                    $_POST['name_department_input'],
                    $_POST['name_specialization_input'],
                    $_POST['education_type_input'],
                    $_POST['sub_input_group']
                );
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
    public function get_all_groups()
    {
        $response = new Response();
        if(isset($_POST['faculty_name']) &
            isset($_POST['department_name']) &
            isset($_POST['specialization_name'])
        ) {
            try {
                $data = Groups::get_all_groups($this->link,$_POST['faculty_name'],$_POST['department_name'],$_POST['specialization_name']);
                if (!$data)
                    $response->set('data', array());
                else
                    $response->set('data', $data);
                $response->set('result', 'success');
            } catch (\Exception $exception) {
                $response->set('error_code', $exception->getMessage());
            }
        }
        else
        {

        }
        return $response->makeJson();
    }
    public function get_all_schedule()
    {
        $response = new Response();
        if(isset($_POST['id'])) {
            try {
                $data = Schedule::get_schedule_for_group($this->link,$_POST['id']);
                if (!$data)
                    $response->set('data', array());
                else
                    $response->set('data', $data);
                $response->set('result', 'success');
            } catch (\Exception $exception) {
                $response->set('error_code', $exception->getMessage());
            }
        }
        else
        {

        }
        return $response->makeJson();
    }
    public function add_schedule()
    {
        $response = new Response();
        if(isset($_POST['id']) && isset($_POST['start_ed']) && isset($_POST['end_ed']) && isset($_POST['start_session']) &&
            isset($_POST['end_session'])) {
            try {
                $data = Schedule::add_schedule($this->link,$_POST['id'],$_POST['start_ed'],$_POST['end_ed'],
                    $_POST['start_session'],$_POST['end_session']);
                if (!$data)
                    $response->set('data', array());
                else
                    $response->set('data', $data);
                $response->set('result', 'success');
            } catch (\Exception $exception) {
                $response->set('error_code', $exception->getMessage());
            }
        }
        else
        {

        }
        return $response->makeJson();
    }
    public function delete_schedule()
    {
        $response = new Response();
        if(isset($_POST['id']) && isset($_POST['start_ed']) && isset($_POST['end_ed']) && isset($_POST['start_session']) &&
            isset($_POST['end_session'])) {
            try {
                $data = Schedule::delete_schedule($this->link,$_POST['id'],$_POST['start_ed'],$_POST['end_ed'],
                    $_POST['start_session'],$_POST['end_session']);
                if (!$data)
                    $response->set('data', array());
                else
                    $response->set('data', $data);
                $response->set('result', 'success');
            } catch (\Exception $exception) {
                $response->set('error_code', $exception->getMessage());
            }
        }
        else
        {

        }
        return $response->makeJson();
    }
}