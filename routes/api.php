<?php

$router->postController('/login', "\App\Http\Controllers\LoginController@postlogin");


$router->get('/logout', "\App\Http\Controllers\LoginController@getLogout");
