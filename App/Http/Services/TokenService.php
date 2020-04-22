<?php
namespace App\Http\Services;

use \Core\Database\Database;
use \Core\helpers\Config;
use Core\JsonWebToken\JWTException;

class TokenService
{
    public static  function generate_token($userdata,$postdata)
    {
        $jwt = new \Core\JsonWebToken\JWT(Config::get('app.secret_key'));

        $data['user_data']=json_encode($userdata);
        $data['result']='success';

        $data['token']=  $jwt->encode([
            'logindata'=>json_encode($postdata),
            'hash'=>md5(json_encode($postdata))
        ]);
        return $data;
    }
    public static  function  parse_token($token)
    {
        try {
            if ($token)
            {
                $jwt = new \Core\JsonWebToken\JWT(Config::get('app.secret_key'));
                $data = $jwt->decode($token);
                return $data;
            }
            else return null;
        }catch (JWTException $exception)
        {
            return null;
        }
    }


}
