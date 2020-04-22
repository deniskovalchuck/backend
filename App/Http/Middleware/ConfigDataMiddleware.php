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
        return true;

    }
}
