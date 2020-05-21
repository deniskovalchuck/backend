<?php

$router->postController('/login', "\App\Http\Controllers\LoginController@postlogin");

$router->group(['before' => 'auth'], function($router){
    $router->postController('/update_token', "\App\Http\Controllers\LoginController@update_token");
    $router->postController('/get_me', "\App\Http\Controllers\LoginController@get_me");

    /*аудитории*/
    $router->postController('/classrooms/get_all_bulding', "\App\Http\Controllers\ClassroomController@get_all_bulding");
    $router->postController('/classrooms/get_all_classrooms', "\App\Http\Controllers\ClassroomController@get_all_classrooms");
    $router->postController('/classrooms/get_all_classrooms_in_building', "\App\Http\Controllers\ClassroomController@get_all_classrooms_in_building");
    $router->postController('/classrooms/add_classroom', "\App\Http\Controllers\ClassroomController@add_classroom");
    $router->postController('/classrooms/delete_classroom', "\App\Http\Controllers\ClassroomController@delete_classroom");
    $router->postController('/classrooms/delete_building', "\App\Http\Controllers\ClassroomController@delete_building");


    /*кафедры*/
    $router->postController('/department/get_all_departments', "\App\Http\Controllers\DepartmentController@get_all_departments");
    $router->postController('/department/get_all_departments_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_with_logo");
    $router->postController('/department/get_all_departments_in_faculty', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty");
    $router->postController('/department/get_all_departments_in_faculty_with_logo', "\App\Http\Controllers\DepartmentController@get_all_departments_in_faculty_with_logo");
    $router->postController('/department/add_department', "\App\Http\Controllers\DepartmentController@add_department");
    $router->postController('/department/delete_department', "\App\Http\Controllers\DepartmentController@delete_department");

    /*типы обучения*/
    $router->postController('/education/add_education_type', "\App\Http\Controllers\EducationController@add_education_type");
    $router->postController('/education/delete_education_type', "\App\Http\Controllers\EducationController@delete_education_type");
    $router->postController('/education/get_all_education_type', "\App\Http\Controllers\EducationController@get_all_education_type");

    /*факультеты*/
    $router->postController('/faculty/get_all_faculties', "\App\Http\Controllers\FacultyController@get_all_faculties");
    $router->postController('/faculty/add', "\App\Http\Controllers\FacultyController@add_faculty");
    $router->postController('/faculty/delete', "\App\Http\Controllers\FacultyController@delete_faculty");
    $router->postController('/faculty/get_all_faculties_no_logo', "\App\Http\Controllers\FacultyController@get_all_faculties_no_logo");


    /*группы*/
    $router->postController('/groups/add_students_groups', "\App\Http\Controllers\GroupController@add_students_groups");
    $router->postController('/groups/delete_student_groups', "\App\Http\Controllers\GroupController@delete_student_groups");
    $router->postController('/groups/get_all_groups', "\App\Http\Controllers\GroupController@get_all_groups");

    /*Lesson*/
    $router->postController('/lessons/get_id_lesson', "\App\Http\Controllers\LessonController@get_id_lesson");
    $router->postController('/lessons/add_lesson', "\App\Http\Controllers\LessonController@add_lesson");
    $router->postController('/lessons/delete_lesson', "\App\Http\Controllers\LessonController@delete_lesson");
    //$router->postController('/lessons/get_all_type_lesson', "\App\Http\Controllers\LessonController@get_all_type_lesson");
    $router->postController('/lessons/get_all_lessons', "\App\Http\Controllers\LessonController@get_all_lessons");
    $router->postController('/lessons/get_all_lessons_by_group', "\App\Http\Controllers\LessonController@get_all_lessons_by_group");
    $router->postController('/lessons/get_all_lessons_by_teacher', "\App\Http\Controllers\LessonController@get_all_lessons_by_teacher");

    /*типы оплат*/
    $router->postController('/payment/add_payment_type', "\App\Http\Controllers\PaymentController@add_payment_type");
    $router->postController('/payment/delete_payment_type', "\App\Http\Controllers\PaymentController@delete_payment_type");
    $router->postController('/payment/get_all_payment_type', "\App\Http\Controllers\PaymentController@get_all_payment_type");

    /*должности*/
    $router->postController('/position/add_position', "\App\Http\Controllers\PositionController@add_position");
    $router->postController('/position/delete_teacher_position', "\App\Http\Controllers\PositionController@delete_teacher_position");
    $router->postController('/position/get_all_teacher_positions', "\App\Http\Controllers\PositionController@get_all_teacher_positions");

    /*специальности*/
    $router->postController('/specilality/get_all_specialization', "\App\Http\Controllers\SpecializationController@get_all_specialization");
    $router->postController('/specilality/get_all_specialization_from_faculty', "\App\Http\Controllers\SpecializationController@get_all_specialization_from_faculty");
    $router->postController('/specilality/get_all_specialization_from_department', "\App\Http\Controllers\SpecializationController@get_all_specialization_from_department");
    $router->postController('/specilality/add_spezialization', "\App\Http\Controllers\SpecializationController@add_spezialization");
    $router->postController('/specilality/delete_specialization', "\App\Http\Controllers\SpecializationController@delete_specialization");

    /*Дисциплины*/
    $router->postController('/subject/get_all_subjects', "\App\Http\Controllers\SubjectController@get_all_subjects");
    $router->postController('/subject/add_subject', "\App\Http\Controllers\SubjectController@add_subject");
    $router->postController('/subject/delete_subject', "\App\Http\Controllers\SubjectController@delete_subject");
    $router->postController('/subject/get_teacher_subjects', "\App\Http\Controllers\SubjectController@get_teacher_subjects");
    $router->postController('/subject/add_teacher_subjects_by_FIO', "\App\Http\Controllers\SubjectController@add_teacher_subjects_by_FIO");
    $router->postController('/subject/add_teacher_subjects_by_login', "\App\Http\Controllers\SubjectController@add_teacher_subjects_by_login");
    $router->postController('/subject/delete_teacher_subjects', "\App\Http\Controllers\SubjectController@delete_teacher_subjects");

    /*преподователи*/
    $router->postController('/teachers/get_teacher_by_login', "\App\Http\Controllers\TeacherController@get_teacher_by_login");
    $router->postController('/teachers/get_teachers_in_faculty', "\App\Http\Controllers\TeacherController@get_teachers_in_faculty");
    $router->postController('/teachers/get_teachers_in_department', "\App\Http\Controllers\TeacherController@get_teachers_in_department");
    $router->postController('/teachers/add_teacher', "\App\Http\Controllers\TeacherController@add_teacher");
    $router->postController('/teachers/delete_teacher', "\App\Http\Controllers\TeacherController@delete_teacher");
    $router->postController('/teachers/get_teacher_info', "\App\Http\Controllers\TeacherController@get_teacher_info");
    $router->postController('/teachers/get_teacher_login', "\App\Http\Controllers\TeacherController@get_teacher_login");
    $router->postController('/teachers/create_sub_for_teacher', "\App\Http\Controllers\TeacherController@create_sub_for_teacher");
    $router->postController('/teachers/delete_sub_for_teacher', "\App\Http\Controllers\TeacherController@delete_sub_for_teacher");
    $router->postController('/teachers/get_all_teacher_positions', "\App\Http\Controllers\TeacherController@get_all_teacher_positions");

    /*week*/
    $router->postController('/weeks/get_all_week', "\App\Http\Controllers\WeeksController@get_all_week");

    /*TypeOfActivityController*/
    $router->postController('/typeofactivity/get', "\App\Http\Controllers\TypeOfActivityController@get_all");
    $router->postController('/typeofactivity/delete', "\App\Http\Controllers\TypeOfActivityController@delete");
    $router->postController('/typeofactivity/add', "\App\Http\Controllers\TypeOfActivityController@add");
    $router->postController('/typeofactivity/get_all_by_type', "\App\Http\Controllers\TypeOfActivityController@get_all_by_type");

});