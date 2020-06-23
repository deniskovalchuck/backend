<?php
//загрузка middleware(фильтров) в маршрутизацию
foreach (middleware as $item=>$value) {
    $router->filter($item, $value);
}
