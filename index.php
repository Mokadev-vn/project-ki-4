<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

spl_autoload_register(function (string $class) {

    $array = explode('\\', $class);
    unset($array[count($array) - 1]);
    $name = implode('/', $array);
    $prefix = implode('\\', $array);
    $root = strtolower($name);

    $classWithoutPrefix = preg_replace('/^' . preg_quote($prefix) . '/', '', $class);
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $classWithoutPrefix) . '.php';
    $path = $root . $file;
    if (file_exists($path)) {
        require_once $path;
    }
});

// set_error_handler(function () {
//     echo '';
// });

require_once 'config/app.php';
require_once 'config/middleware.php';
require_once 'config/database.php';
require_once 'router.php';
