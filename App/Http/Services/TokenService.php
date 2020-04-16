<?php
namespace App\Http\Services;

use \Core\Database\Database;
use \Core\helpers\Config;
use Core\JsonWebToken\JWTException;

class TokenService
{
    public static  function generate_token($userdata)
    {
        $jwt = new \Core\JsonWebToken\JWT(Config::get('app.secret_key'));

        $data['user_data']=json_encode($userdata);
        $data['result']='success';

        $data['token']=  $jwt->encode([
            'login'=>$_POST['login'],
            'password'=>$_POST['password'],
            'hash'=>md5($_POST['login'].$_POST['password'])
        ]);
        return $data;
    }
    public static  function  parse_token()
    {
        try {
            if (isset($_POST['token']))
            {
                $jwt = new \Core\JsonWebToken\JWT(Config::get('app.secret_key'));
                $data = $jwt->decode($_POST['token']);
                return $data;
            }
            else return null;
        }catch (JWTException $exception)
        {
            return null;
        }
    }


}
