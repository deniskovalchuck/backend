<?php
namespace Core\Route;

interface IMiddleware
{
    public static function handle($httpMethod,$uri):bool;
}
