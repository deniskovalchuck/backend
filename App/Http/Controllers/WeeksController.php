<?php

namespace App\Http\Controllers;

use App\Data\DB\Week;
use Core\helpers\Config;
use Core\helpers\Response;

class WeeksController {
     var   $link = null;

     public function __construct()
     {
         $this->link = Config::get('app.database.connection');
     }

    public  function get_all_week(){
        $response = new Response();
        try {
            $data = Week::get_all_week($this->link);
            if(!$data)
                $response->set('data',array());
            else
            {
                $new_array=array();
                for($i=0;$i<count($data);$i++)
                {
                    $new_array[$i]=$data[$i]['input_week_day'];
                }
                $new_array = array_unique($new_array);

                $response->set('data',$new_array);
            }
            $response->set('result','success');
        }
        catch (\Exception $exception)
        {
            $response->set('error_code',$exception->getMessage());
        }
        return $response->makeJson();
    }


}
