<?php

$loader = function ($class) {
    if (strpos($class, "\\") === 0) {
        $class = substr($class, 1);
    }

    if (strpos($class, "Giftery\\") === 0) {
        $class = substr($class, 8);
        $file = __DIR__ . '/src/' . str_replace("\\", '/', $class) . '.php';

        if (file_exists($file)) {
            /** @noinspection PhpIncludeInspection */
            include_once $file;
        }
    }
};

spl_autoload_register($loader, true, true);
