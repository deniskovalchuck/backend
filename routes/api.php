<?php

$router->postController('/login', "\App\Http\Controllers\LoginController@postlogin");

$router->group(['before' => 'auth'], function($router){
    
    /*аудитории*/
    $router->postController('/classrooms/get_all_bulding', "\App\Http\Controllers\ClassroomController@get_all_bulding");
    $router->postController('/classrooms/get_all_classrooms', "\App\Http\Controllers\ClassroomController@get_all_classrooms");
    $router->postController('/classrooms/get_all_classrooms_in_building', "\App\Http\Controllers\ClassroomController@get_all_classrooms_in_building");
    $router->postController('/classrooms/add_classroom', "\App\Http\Controllers\ClassroomController@add_classroom");
    $router->postController('/classrooms/delete_classroom', "\App\Http\Controllers\ClassroomController@delete_classroom");

});