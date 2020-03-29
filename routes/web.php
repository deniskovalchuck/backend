<?php

$router->any('/', function(){
    return 'This route responds to any method (POST, GET, DELETE, OPTIONS, HEAD etc...) at the path /example';
});
