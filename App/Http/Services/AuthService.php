<?php
namespace App\Http\Services;

use \Core\Database\Database;
use \Core\helpers\Config;
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
        if(TokenService::parse_token()!=null)
            return true;
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
        $data = array(
            "result"=>"fail",
            "token"=>"",
            "new_token"=>"",
            "user_data"=>"",
            "error_code"=>"");

        $link = new \Core\Database\Database();
        $postData = file_get_contents('php://input');
        $postData = json_decode($postData, true);
             if (isset($postData['login']) & isset($postData['password']) & isset($postData['host'])
                    & isset($postData['port']) & isset($postData['database']) & isset($postData['charset'])) {
                    if($link->tryConnectFull($postData['host'],$postData['port'],$postData['database'],
                            $postData['login'],$postData['password'],$postData['charset'])==true)
                    {
                        $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                        return $data;
                    }
                    else
                    {
                        $data['error_code']="not connect with data";
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
                                $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                                return $data;
                            }
                            else
                            {
                                $data['error_code']="Не верно введен логин или пароль или ошибка подключения к серверу";
                                return $data;
                            }
                        }
                        else
                        {
                            if($link->tryConnect($postData['nameserver'],'','')==true)
                            {
                                $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                                return $data;
                            }
                            else
                            {
                                $data['error_code']="Ошибка подключения к серверу баз данных";
                                return $data;
                            }
                        }
                    }
                    else  if(isset($postData['login']) & isset($postData['password']))
                    {
                        if($link->tryConnect('',$postData['login'],$postData['password'])==true)
                        {
                            $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                            return $data;
                        }
                        else
                        {
                            $data['error_code']="Не верно введен логин или пароль";
                            return $data;
                        }
                    }
                    else
                {
                        $data['error_code']="Отправлен пустой логин и пароль";
                    return $data;
                }

    }

    public static function Logout()
    {
    }

}
