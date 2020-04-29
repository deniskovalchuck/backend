<?php
namespace App\Http\Middleware;
use Core\Route\IMiddleware;

class  ConfigDataMiddleware implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):bool
    {

        /*  $postData = file_get_contents('php://input');
       $_POST = json_decode($postData, true);*/

        foreach ($_FILES as $key=>$value)
        {
            $_POST[$key]=$value;
        }
        return true;

    }
}
