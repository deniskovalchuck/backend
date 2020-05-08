<?php
namespace App\Http\Controllers;

use App\Data\DB\Specialization;
use Core\helpers\Config;
use Core\helpers\Converter;
use Core\helpers\Response;


class SpecializationController{

    var   $link = null;

    public function __construct()
    {
        $this->link = Config::get('app.database.connection');
    }

    public  function get_all_specialization(){
        $response = new Response();
            try {
                $data = Specialization::get_all_specialization($this->link);
                if (!$data)
                    $response->set('data', array());
                else
                    $response->set('data', $data);
                $response->set('result', 'success');
            } catch (\Exception $exception) {
                $response->set('error_code', $exception->getMessage());
            }
        return $response->makeJson();
    }

    public  function get_all_specialization_from_faculty(){
        $response = new Response();
        if(isset($_POST['faculty_name'])) {
            try {
                $data = Specialization::get_all_specialization_from_faculty($this->link,$_POST['faculty_name']);
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

        public function get_all_specialization_from_department(){
        $response = new Response();
        if(isset($_POST['department_name'])) {
            try {
                $data = Specialization::get_all_specialization_from_department($this->link,$_POST['department_name']);
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


    public function add_spezialization(){
        $response = new Response();
        if(isset($_POST['name_input_specialization']) &
            isset($_POST['name_input_faculty']) &
            isset($_POST['name_input_department']) &
            isset($_POST['abbreviation'])
        ) {
            try {
                $data = Specialization::add_spezialization($this->link,$_POST['name_input_specialization'],
                    $_POST['name_input_faculty'],$_POST['name_input_department'],$_POST['abbreviation']);
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

    public function delete_specialization(){
        $response = new Response();
        if(isset($_POST['name_faculty_for_delete']) &
            isset($_POST['name_department_for_delete']) &
            isset($_POST['name_specialization_for_delete'])
        ) {
            try {
                $data = Specialization::delete_specialization ($this->link,$_POST['name_faculty_for_delete'],
                    $_POST['name_department_for_delete'],$_POST['name_specialization_for_delete']);
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