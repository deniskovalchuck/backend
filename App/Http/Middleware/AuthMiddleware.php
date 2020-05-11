<?php
namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use Core\Route\IMiddleware;

class  AuthMiddleware implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):bool
    {

        $data =  AuthService::checkLogin();
        return  $data;
    }
}
