<?php

namespace App\Http\Controllers;

use App\Data\DB\Faculty;
use Core\helpers\Config;
use Core\helpers\Converter;
use Core\helpers\Response;

class FacultyController {
    var   $link = null;

    public function __construct()
    {
        $this->link = Config::get('app.database.connection');
    }
    public  function get_all_faculties(){
        $response = new Response();

            try {
                $data = Faculty::get_all_faclties($this->link);
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
    public  function get_all_faculties_no_logo(){
        $response = new Response();

        try {
            $data = Faculty::get_all_faclties($this->link);
            if(!$data)
                $response->set('data',array());
            else {
                $res = array();
                for($i=0;$i<count($data);$i++)
                {
                    $res[$i] = array();
                    $res[$i]['name_faculties']=$data[$i]['name_faculties'];
                }
                $response->set('data', $res);
            }
            $response->set('result','success');
        }
        catch (\Exception $exception)
        {
            $response->set('error_code',$exception->getMessage());
        }

        return $response->makeJson();
    }
    public  function add_faculty(){
        $response = new Response();
        if(isset($_POST['logo']) &
            isset($_POST['faculty']))
        {
            try {
                $data = Faculty::add_faculty($this->link,$_POST['faculty'],$_POST['logo']);
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

    public  function delete_faculty(){
        $response = new Response();
        if(isset($_POST['faculty']))
        {
            try {
                $data = Faculty::delete_faculty($this->link,$_POST['faculty']);
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
