<?php

declare(strict_types=1);

if (!defined('APP_PATH')) {
    define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app');
}

spl_autoload_register(function ($class) {
    require_once APP_PATH . DIRECTORY_SEPARATOR . str_replace('\\', '/', $class) . '.php';
});
