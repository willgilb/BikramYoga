<?php

declare(strict_types=1);

// The full URL of your website
define('URI_PUBLIC', 'https://bikramyoga.test/');

// Database configuration
define('DRIVER', 'mysql');
define('HOST', 'localhost');
define('PORT', 3306);
define('DBNAME', 'bikramyoga');
define('CHARSET', 'utf8mb4');
define('USER', 'root');
define('PASSWORD', 'qwerty1972');

// Locales configuration
define('TIMEZONE', 'Europe/Amsterdam');
define('LOCALE', 'nl_NL');

// Debug configuration
define('DEBUG', true);

// Warning: Do not change or remove the value of the AUTHENTICATION_PEPPER
// If you do so you must update all user passwords
define('AUTHENTICATION_PEPPER', '6kTd@#vFK!C<+qK[5!Dw8%>43jF\,a');
