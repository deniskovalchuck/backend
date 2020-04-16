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

             if (isset($_POST['login']) & isset($_POST['password']) & isset($_POST['host'])
                    & isset($_POST['port']) & isset($_POST['database']) & isset($_POST['charset'])) {
                    if($link->tryConnectFull($_POST['host'],$_POST['port'],$_POST['database'],
                            $_POST['login'],$_POST['password'],$_POST['charset'])==true)
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
                    if(isset($_POST['nameserver']))
                    {
                        if(isset($_POST['login']) & isset($_POST['password']))
                        {
                            if($link->tryConnect($_POST['nameserver'],$_POST['login'],$_POST['password'])==true)
                            {
                                $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                                return $data;
                            }
                            else
                            {
                                $data['error_code']="login or password not valid";
                                return $data;
                            }
                        }
                        else
                        {
                            if($link->tryConnect($_POST['nameserver'],'','')==true)
                            {
                                $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                                return $data;
                            }
                            else
                            {
                                $data['error_code']="error with netwwork connection to database server";
                                return $data;
                            }
                        }
                    }
                    else  if(isset($_POST['login']) & isset($_POST['password']))
                    {
                        if($link->tryConnect('',$_POST['login'],$_POST['password'])==true)
                        {
                            $data = TokenService::generate_token(AuthService::get_user_data($link,$data));
                            return $data;
                        }
                        else
                        {
                            $data['error_code']="login or password not valid";
                            return $data;
                        }
                    }
                    else
                {
                    $data['error_code']="data empty";
                    return $data;
                }

    }

    public static function Logout()
    {
    }

}
