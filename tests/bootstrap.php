<?php
require __dir__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/lib/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});