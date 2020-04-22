<?php
namespace App\Http\Middleware;

use App\Http\Services\AuthService;
use App\Http\Services\TokenService;
use Core\Route\IMiddleware;

class  AuthMiddleware implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):boolean
    {
        echo $uri;
        return AuthService::checkLogin();
    }
}
