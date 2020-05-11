<?php

namespace App\Http\Controllers;

use App\Data\DB\Department;
use Core\helpers\Config;
use Core\helpers\Converter;
use Core\helpers\Response;

class DepartmentController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }
    public function get_all_departments(){
        $response = new Response();
            try {
                $data = Department::get_all_departments($this->link);
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

    public function get_all_departments_with_logo(){
        $response = new Response();
            try {
                $data = Department::get_all_departments_with_logo($this->link);
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

    public function get_all_departments_in_faculty(){
        $response = new Response();
        if(isset($_POST['faculty']))
        {
            try {
                $data = Department::get_all_departments_in_faculty($this->link,$_POST['faculty']);
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

    public function get_all_departments_in_faculty_with_logo(){
        $response = new Response();
        if(isset($_POST['faculty']))
        {
            try {
                $data = Department::get_all_departments_in_faculty_with_logo($this->link,$_POST['faculty']);
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

    public function add_department(){
        $response = new Response();
        if(isset($_POST['department_name']) &
            isset($_POST['logo_input_department']) &
            isset($_POST['faculty']) &
            isset($_POST['num_building_input_department']) &
            isset($_POST['num_class_input_department'])
        )
        {
            try {
                $data = Department::add_department($this->link,$_POST['department_name'],
                     $_POST['logo_input_department'],
                    $_POST['faculty'],
                    $_POST['num_building_input_department'],
                    $_POST['num_class_input_department']
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

    public function delete_department(){

        $response = new Response();
        if(isset($_POST['department_name']) &
            isset($_POST['faculty']))
        {
            try {
                $data = Department::delete_department($this->link,$_POST['faculty'],$_POST['department_name']);
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
