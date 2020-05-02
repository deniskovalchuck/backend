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
        if (isset($_SERVER['HTTP_TOKEN']))
        {
            $token = $_SERVER['HTTP_TOKEN'];
            $token_data = TokenService::parse_token($token);
            if($token_data!=null)
            {
                $tmp = json_decode($token_data['logindata'],true);
                Config::set('app.token',$token);

                // попробовать приконектится к базе,
                // если да - сохранить в бд подключение и вернуть true, иначе нет
                $data = self::tryconnect($tmp);
                    return true;


            }
            else
            {
                $request->set('error_code',Config::get('errors.token_prefix').Config::get('errors.token.invalid_token')." Error Token");
                return false;
            }
        }
        else
            {

                $request->set('error_code',Config::get('errors.token_prefix').Config::get('errors.token.not_token')." Error Token");
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
        if (isset($postData['login']) & isset($postData['password']) & isset($postData['host'])
            & isset($postData['port']) & isset($postData['database']) & isset($postData['charset'])) {
            if($link->tryConnectFull($postData['host'],$postData['port'],$postData['database'],
                    $postData['login'],$postData['password'],$postData['charset'])==true)
            {
                Config::set('app.database.connection',$link);
                Config::set('app.database.data',$postData);

                $response->set('data',json_encode(self::get_user_data($link,$postData['login'])));
                $response->set('result','success');
                return $response;
            }
            else
            {
                $response->set('error_code',Config::get('errors.connection_prefix')
                    .Config::get('errors.connection.not_connect_with_data'));
                return $response;
            }
        }
        else
            if(isset($postData['nameserver']))
            {
                if(isset($postData['login']) & isset($postData['password']))
                {
                    if($link->tryConnect($postData['nameserver'],$postData['login'],$postData['password'])==true)
                    {
                        Config::set('app.database.connection',$link);
                        Config::set('app.database.data',$postData);

                        $response->set('data',json_encode(self::get_user_data($link,$postData['login'])));
                        $response->set('result','success');
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
                    if($link->tryConnect($postData['nameserver'],'','')==true)
                    {

                        Config::set('app.database.connection',$link);
                        Config::set('app.database.data',$postData);

                        $response->set('data',json_encode(self::get_user_data($link,$postData['login'])));
                        $response->set('result','success');
                        return $response;
                    }
                    else
                    {
                        $response->set('error_code',Config::get('errors.connection_prefix')
                            .Config::get('errors.connection.error_connect_to_db'));

                        return $response;
                    }
                }
            }
            else  if(isset($postData['login']) & isset($postData['password']))
            {
                if($link->tryConnect('',$postData['login'],$postData['password'])==true)
                {

                    Config::set('app.database.connection',$link);
                    Config::set('app.database.data',$postData);

                    $response->set('data',json_encode(self::get_user_data($link,$postData['login'])));
                    $response->set('result','success');
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
