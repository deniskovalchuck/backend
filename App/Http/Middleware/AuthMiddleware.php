<?php
namespace App\Http\Middleware;

use Core\Route\IMiddleware;

class  AuthMiddleware implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):boolean
    {
        echo $uri;
        return true;
    }
}
