<?php
use Shooyaaa\Three\Core\Container;
require __dir__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class) {
    //echo 'composer load ', "$class\r\n";
    $path = __DIR__ . '/lib/' . $class . '.php';
    //echo 'composer path ', $path, "\r\n";
    if (file_exists($path)) {
        require_once $path;
    }
});
