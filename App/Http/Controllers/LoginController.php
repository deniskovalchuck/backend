<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Core\helpers\Config;
use Core\helpers\Response;

class LoginController {


    /**
     * @var $login
     * @var $password
     * @var $nameserver ==null
     * @var $host ==null
     * @var $port==null
     * @var $database==null
     * @var $charset==null
     * @return $json (result=>success|fail,token, user_data)
     */
    public function postlogin()
    {
        return AuthService::Login();
    }
    public function getLogout()
    {
        return AuthService::Logout();
    }
    public function update_token()
    {}
    public function get_me()
    {
        $response = new Response();
        $response->set('data',json_encode(Config::get('app.user')));
        $response->set('result','success');
        return $response->make();
    }
}
