<?php
namespace App\Http\Services;

use \Core\Database\Database;
use \Core\helpers\Config;
use Core\JsonWebToken\JWT;
use Core\JsonWebToken\JWTException;

class AuthService
{
    public static function get_user_data($link,$login)
    {
      return  \App\Data\DB\Teacher::get_teacher_by_login($link,$_POST['login']);

    }

    /**
     * проверка на авторизацию.
     * @return bool
     */
    public static function checkLogin()
    {
        if (isset($_SERVER['AUTH_TOKEN']))
        {
            $token = $_SERVER['AUTH_TOKEN'];
            $token_data = TokenService::parse_token($token);
            if($token_data!=null)
            {
                // попробовать приконектится к базе,
                // если да - сохранить в бд подключение и вернуть true, иначе нет


            }
            else return false;
        }
        else return  false;

    }
    /**
     * @var $login==null
     * @var $password==null
     * @var $nameserver ==null
     * @var $host ==null
     * @var $port==null
     * @var $database==null
     * @var $charset==null
     * @return $json (result=>success|fail,token, user_data)
     */
    public static function Login()
    {

        $postData = file_get_contents('php://input');
        $postData = json_decode($postData, true);
        AuthService::tryconnect($postData);

    }

    public static function Logout()
    {
    }

    private static function tryconnect($postData)
    {
        $data = array(
            "result"=>"fail",
            "token"=>"",
            "user_data"=>"",
            "error_code"=>"",
        );

        $link = new \Core\Database\Database();
        if (isset($postData['login']) & isset($postData['password']) & isset($postData['host'])
            & isset($postData['port']) & isset($postData['database']) & isset($postData['charset'])) {
            if($link->tryConnectFull($postData['host'],$postData['port'],$postData['database'],
                    $postData['login'],$postData['password'],$postData['charset'])==true)
            {
                $data = TokenService::generate_token(AuthService::get_user_data($link,$data,  $postData));
                return $data;
            }
            else
            {
                $data['error_code']=Config::get('errors.connection_prefix').Config::get('errors.connection.not_connect_with_data');
                return $data;
            }
        }
        else
            if(isset($postData['nameserver']))
            {
                if(isset($postData['login']) & isset($postData['password']))
                {
                    if($link->tryConnect($postData['nameserver'],$postData['login'],$postData['password'])==true)
                    {
                        $data = TokenService::generate_token(AuthService::get_user_data($link,$data,  $postData));
                        return $data;
                    }
                    else
                    {
                        $data['error_code']=Config::get('errors.connection_prefix').Config::get('errors.connection.invalid_login_or_password');

                        return $data;
                    }
                }
                else
                {
                    if($link->tryConnect($postData['nameserver'],'','')==true)
                    {
                        $data = TokenService::generate_token(AuthService::get_user_data($link,$data,  $postData));
                        return $data;
                    }
                    else
                    {
                        $data['error_code']=Config::get('errors.connection_prefix').Config::get('errors.connection.error_connect_to_db');

                        return $data;
                    }
                }
            }
            else  if(isset($postData['login']) & isset($postData['password']))
            {
                if($link->tryConnect('',$postData['login'],$postData['password'])==true)
                {
                    $data = TokenService::generate_token(AuthService::get_user_data($link,$data,  $postData));
                    return $data;
                }
                else
                {
                    $data['error_code']=Config::get('errors.connection_prefix').Config::get('errors.connection.invalid_login_or_password');
                    return $data;
                }
            }
            else
            {
                $data['error_code']=Config::get('errors.connection_prefix').Config::get('errors.connection.empty_login_or_password');

                return $data;
            }
    }

}
