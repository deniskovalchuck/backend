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
    $router->postController('/faculty/get_all_faculties_no_logo', "\App\Http\Controllers\FacultyController@get_all_faculties_no_logo");

    /*кафедры*/
    $router->postController('/department/get_all_departments', "\App\Http\Controllers\DepartmentController@get_all_departments");
    $router->postController('/department/get_all_departments_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_with_logo");
    $router->postController('/department/get_all_departments_in_faculty', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty");
    $router->postController('/department/get_all_departments_in_faculty_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty_with_logo");
    $router->postController('/department/add_department', "\App\Http\Controllers\DepartmentController@add_department");
    $router->postController('/department/delete_department', "\App\Http\Controllers\DepartmentController@delete_department");


    /*группы*/
    $router->postController('/groups/add_students_groups', "\App\Http\Controllers\GroupController@add_students_groups");
    $router->postController('/groups/delete_student_groups', "\App\Http\Controllers\GroupController@delete_student_groups");
    $router->postController('/groups/get_all_groups', "\App\Http\Controllers\GroupController@get_all_groups");

    /*специпльности*/
    $router->postController('/specilality/get_all_specialization', "\App\Http\Controllers\SpecializationController@get_all_specialization");
    $router->postController('/specilality/get_all_specialization_from_faculty', "\App\Http\Controllers\SpecializationController@get_all_specialization_from_faculty");
    $router->postController('/specilality/get_all_specialization_from_department', "\App\Http\Controllers\SpecializationController@get_all_specialization_from_department");
    $router->postController('/specilality/add_spezialization', "\App\Http\Controllers\SpecializationController@add_spezialization");
    $router->postController('/specilality/delete_specialization', "\App\Http\Controllers\SpecializationController@delete_specialization");


});