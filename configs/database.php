<?php
return [

    //подключениие, используемое по умолчанию
    'default_connection' => 'server1',

    //подключениие, используемое для служебных операций (планировщик и т.д) (должен иметь и логин и пароль)
    'system_connection' => 'server2',

    //список серверов бд
    'ServerNames' => [
        'server1' => [
            'host' => 'server.myteh24.ru',
            'port' =>'5432',
            'database' => 'semik_univer',
            'username' => '',//если пусто - ожидать от пользователя, иначе использовать этот
            'password' => '',//если пусто - ожидать от пользователя, иначе использовать этот
            'charset' => 'utf8',
        ],
        'server2' => [
            'host' => '127.0.0.1',
            'port' =>'5432',
            'database' => 'forge',
            'username' => 'forge',
            'password' => 'DB_PASSWORD',
            'charset' => 'utf8',
        ],

    ],

];
