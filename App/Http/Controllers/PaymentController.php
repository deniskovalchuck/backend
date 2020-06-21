<?php

namespace App\Http\Controllers;

use Core\helpers\Config;
use Core\helpers\Response;

class PaymentController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }
    /*return string ('Запись уже существует!', 'Запись добавлена!')*/
    public  function add_payment_type(){
        $response = new Response();
        if(isset($_POST['input_name_payment_type']) && isset($_POST['input_coefficient']))
        {
            try {
                $data = \App\Data\DB\Payments::add_payment_type($this->link,$_POST['input_name_payment_type'],$_POST['input_coefficient']);
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

    /*return string ('Запись успешно удалена!', 'Записи нет в базе!')*/
    public  function delete_payment_type(){
        $response = new Response();
        if(isset($_POST['input_name_payment_type']))
        {
            try {
                $data = \App\Data\DB\Payments::delete_payment_type($this->link,$_POST['input_name_payment_type']);
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

    public  function get_all_payment_type(){
        $response = new Response();
            try {
                $data = \App\Data\DB\Payments::get_all_payment_type($this->link);
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

}
