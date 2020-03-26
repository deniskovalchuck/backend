<?php
return [

    //подключениие, используемое по умолчанию
    'default_connection' => 'server1',
    //список серверов бд
    'ServerNames' => [
        'server1' => [
            'host' => '127.0.0.1',
            'port' =>'5432',
            'database' => 'forge',
            'username' => '',//если пусто - ожидать от пользователя, иначе использовать этот
            'password' => '',//если пусто - ожидать от пользователя, иначе использовать этот
            'charset' => 'utf8',
            'prefix' => '',
        ],
        'server2' => [
            'host' => '127.0.0.1',
            'port' =>'5432',
            'database' => 'forge',
            'username' => 'forge',
            'password' => 'DB_PASSWORD',
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

];
