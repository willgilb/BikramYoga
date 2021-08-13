<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    require_once APP_PATH . DS . str_replace('\\', '/', $class) . '.php';
});
