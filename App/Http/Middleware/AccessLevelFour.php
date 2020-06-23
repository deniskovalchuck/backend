<?php
namespace App\Http\Middleware;

use Core\Route\IMiddleware;
use \Core\helpers\Config;

class  AccessLevelFour implements IMiddleware
{
    //
    public static function handle($httpMethod,$uri):bool
    {
        $user_data= Config::get('app.data');
        if($user_data['access_level']['access_level']==4)
        {
            return true;
        }
        return  false;
    }
}
