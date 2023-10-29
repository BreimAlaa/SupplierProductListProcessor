<?php

spl_autoload_register(function ($class) {
    // remove the app prefix
    $class = substr($class, 3);

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $path = dirname(__DIR__). DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($path)) {
        require_once $path;
    } else {
        throw new Exception("{$path} not found");
    }
});