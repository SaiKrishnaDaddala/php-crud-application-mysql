<?php
spl_autoload_register(function ($class_name) {
    $class_file = __DIR__ . '/database/' . strtolower($class_name) . '.php';
    if (file_exists($class_file)) {
        include $class_file;
    } else {
        die("Class file for {$class_name} not found.");
    }
});
