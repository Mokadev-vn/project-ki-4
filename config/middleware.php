<?php
use Core\Middleware;

Middleware::$middleware = [
    'checkLogin' => 'App\Middleware\CheckLogin',
    'falseLogin' => 'App\Middleware\FalseLogin',
    'AuthAdmin'  => 'App\Middleware\AuthAdmin',
];