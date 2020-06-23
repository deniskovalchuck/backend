<?php
namespace App\Http\Middleware;

use Core\Route\IMiddleware;
use \Core\helpers\Config;

class  AccessLevelThree implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):bool
    {
        $user_data= Config::get('app.data');
        if($user_data['access_level']['access_level']==3)
        {
            return true;
        }
        return  false;
    }
}
