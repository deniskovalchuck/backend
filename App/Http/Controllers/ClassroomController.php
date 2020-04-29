<?php

namespace App\Http\Controllers;

use App\Data\DB\Classrooms;
use Core\helpers\Config;
use Core\helpers\Response;

class ClassroomController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    public  function get_all_bulding(){
        $response = new Response();
        try {
            $data = Classrooms::get_all_bulding($this->link);
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

    public  function get_all_classrooms(){
        $response = new Response();

        try {
            $data = Classrooms::get_all_classrooms($this->link);
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

    public  function get_all_classrooms_in_building(){
        $response = new Response();
        if(isset($_POST['num_building']))
      {
          try {
              $data = Classrooms::get_all_classrooms_in_building($this->link,$_POST['num_building']);
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

    public  function add_classroom(){

        $response = new Response();
        if(isset($_POST['num_building']) & isset($_POST['num_input_class']))
        {
            try {
                $data = Classrooms::add_classroom($this->link,$_POST['num_building'],$_POST['num_input_class']);
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


    public  function delete_building(){
        $response = new Response();
        if(isset($_POST['num_building']))
        {
            try {
                $data = Classrooms::delete_building($this->link,$_POST['num_building']);
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

    public  function delete_classroom(){
        $response = new Response();
        if(isset($_POST['num_input_class']))
        {
            try {
                $data = Classrooms::delete_classroom($this->link,$_POST['num_input_class']);
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
