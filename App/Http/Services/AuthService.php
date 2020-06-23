<?php
namespace App\Http\Services;

use \Core\helpers\Config;
use \Core\helpers\Response;

class AuthService
{
    public static function get_user_data($link,$login)
    {
      return  \App\Data\DB\Teacher::get_teacher_by_login($link,$login);

    }

    /**
     * проверка на авторизацию.
     * @return bool
     */
    public static function checkLogin()
    {
        $request = new Response();
        if (isset($_SERVER['HTTP_TOKEN'])) {
            $token = $_SERVER['HTTP_TOKEN'];
            $token_data = TokenService::parse_token($token);
            if ($token_data != null) {
                $tmp = json_decode($token_data['logindata'], true);
                Config::set('app.token', $token);
                $data = self::tryconnect($tmp);
                return true;

            } else {
                echo $request->makeJson();
                $request->set('error_code', Config::get('errors.token_prefix') . Config::get('errors.token.invalid_token') . " Error Token");
                return false;

            }
        }
        else
            {
                echo $request->makeJson();
                $request->set('error_code', Config::get('errors.token_prefix') . Config::get('errors.token.not_token') . " Error Token");
                return false;
            }

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
        $response =  AuthService::tryconnect($_POST);
        if($response->get('result')=="success")
        {
            $response->set('token',TokenService::generate_token($_POST));
            if($response->get('token') ==null)
            {
                $response->set('result','fail');
            }else
            Config::set('app.token',$response->get('token'));

        }
        return $response->makeJson();
    }

    public static function Logout()
    {
    }

    private static function tryconnect($postData)
    {
        $response = new Response();
        $link = new \Core\Database\Database();
             if(isset($postData['login']) & isset($postData['password']))
            {
                if($link->tryConnect('')==true)
                {

                    Config::set('app.database.connection',$link);
                    $user_data = self::get_user_data($link,$postData['login']);
                    if(count($user_data)>0)
                    {
                        if($user_data[0]['password_teacher']==$postData['password'])
                        {
                            $user_data[0]['access_level']=\App\Data\DB\Teacher::get_access_rights_by_login($link,$postData['login'])[0];
                            $response->set('data',$user_data[0] );
                            Config::set('app.data',$user_data[0]);

                            $response->set('result','success');
                        }
                        else
                        {
                            $response->set('error_code',Config::get('errors.connection_prefix')
                            .Config::get('errors.connection.invalid_login_or_password'));
                        }
                    }
                    else
                    {
                        $response->set('error_code',Config::get('errors.connection_prefix')
                        .Config::get('errors.connection.invalid_login_or_password'));
                    }
                    return $response;
                }
                else
                {
                    $response->set('error_code',Config::get('errors.connection_prefix')
                        .Config::get('errors.connection.invalid_login_or_password'));
                    return $response;
                }
            }
            else
            {
                $response->set('error_code',Config::get('errors.connection_prefix')
                    .Config::get('errors.connection.empty_login_or_password'));

                return $response;
            }
    }

}
