<?php
namespace Core\helpers;

class Response
{

   var $data = array();
    public function __construct()
    {
        $this->data = array(
            "result"=>"fail",
            "token"=>'',
            "data"=>"",
            "error_code"=>"",
        );
    }
    public function init($data){
        $this->data=$data;
    }

    public function  set($key,$value)
   {
       $this->data[$key]=$value;
   }
    public function get($key){
        return $this->data[$key];
    }
   public function remove($key){
        unset($this->data[$key]);
   }
   public function  makeJson(){
        return json_encode($this->data);
   }
   public function  make(){
    return $this->data;
}


}