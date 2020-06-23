<?php
return [

    //подключениие, используемое по умолчанию
    'default_connection' => 'server1',

    //список серверов бд
    'ServerNames' => [
        'server1' => [
            'host' => 'server.myteh24.ru',
            'port' =>'5432',
            'database' => 'semik_univer',
            'username' => 'semik_semikalex',//если пусто - ожидать от пользователя, иначе использовать этот
            'password' => 'Shdenis21',//если пусто - ожидать от пользователя, иначе использовать этот
            'charset' => 'utf8',
        ],
        

    ],

];
