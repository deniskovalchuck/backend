<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;

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
}
