<?php

$router->postController('/login', "\App\Http\Controllers\LoginController@postlogin");

$router->group(['before' => 'auth'], function($router){
    $router->postController('/update_token', "\App\Http\Controllers\LoginController@update_token");

    /*аудитории*/
    $router->postController('/classrooms/get_all_bulding', "\App\Http\Controllers\ClassroomController@get_all_bulding");
    $router->postController('/classrooms/get_all_classrooms', "\App\Http\Controllers\ClassroomController@get_all_classrooms");
    $router->postController('/classrooms/get_all_classrooms_in_building', "\App\Http\Controllers\ClassroomController@get_all_classrooms_in_building");
    $router->postController('/classrooms/add_classroom', "\App\Http\Controllers\ClassroomController@add_classroom");
    $router->postController('/classrooms/delete_classroom', "\App\Http\Controllers\ClassroomController@delete_classroom");
    $router->postController('/classrooms/delete_building', "\App\Http\Controllers\ClassroomController@delete_building");

    /*факультеты*/
    $router->postController('/faculty/get_all_faculties', "\App\Http\Controllers\FacultyController@get_all_faculties");
    $router->postController('/faculty/add', "\App\Http\Controllers\FacultyController@add_faculty");
    $router->postController('/faculty/delete', "\App\Http\Controllers\FacultyController@delete_faculty");
    $router->postController('/faculty/get_all_faculties_no_logo', "\App\Http\Controllers\FacultyController@get_all_faculties");

    /*кафедры*/
    $router->postController('/department/get_all_departments', "\App\Http\Controllers\DepartmentController@get_all_departments");
    $router->postController('/department/get_all_departments_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_with_logo");
    $router->postController('/department/get_all_departments_in_faculty', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty");
    $router->postController('/department/get_all_departments_in_faculty_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty_with_logo");
    $router->postController('/department/add_department', "\App\Http\Controllers\DepartmentController@add_department");
    $router->postController('/department/delete_department', "\App\Http\Controllers\DepartmentController@delete_department");




});