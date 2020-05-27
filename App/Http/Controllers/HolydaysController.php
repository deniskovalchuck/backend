<?php

namespace App\Http\Controllers;

use App\Data\DB\Holidays;
use App\Data\DB\Week;
use Core\helpers\Config;
use Core\helpers\Response;

class HolydaysController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    public  function get_all(){
        $response = new Response();
        try {
            $data = Holidays::get_all_holidays($this->link);
            if(!$data)
                $response->set('data',array());
            else
            {
                $response->set('data',$data);
            }
            $response->set('result','success');
        }
        catch (\Exception $exception)
        {
            $response->set('error_code',$exception->getMessage());
        }
        return $response->makeJson();
    }
    public function delete()
    {
        $response = new Response();
        if( isset($_POST['id']))
        {
            try {

                $data = Holidays::delete_holiday($this->link, $_POST['id']);
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
    public function add()
    {
        $response = new Response();
        if( isset($_POST['name_input_holiday']) && isset($_POST['date_input_holiday_from'])
            && isset($_POST['date_input_holiday_to']))
        {
            try {

                $data = Holidays::add_holiday($this->link, $_POST['name_input_holiday'], $_POST['date_input_holiday_from']
                    , $_POST['date_input_holiday_to']);
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
