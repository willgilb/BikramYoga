<?php

declare(strict_types=1);

use Core\DotEnv;

// load the enviroment file
(new DotEnv(__DIR__ . '/.env'))->load();

ini_set('default_charset', 'UTF-8');
date_default_timezone_set(getenv('TIMEZONE') ?: 'UTC');
setlocale(LC_ALL, getenv('LOCALE') ?: 'en_EN');

// define some paths
define('DS', DIRECTORY_SEPARATOR);
define('ABS_PATH', dirname(__DIR__));
define('VIEWS_DIR', APP_PATH . DS . 'View' . DS);
define('URI_PUBLIC', getenv('URI_PUBLIC') ?: 'URI_PUBLIC not set!');

// public paths
define('ASSETS_PATH', 'assets/');
define('CSS_PATH', URI_PUBLIC . ASSETS_PATH . 'css/');
define('JS_PATH', URI_PUBLIC . ASSETS_PATH . 'js/');
define('IMG_PATH', URI_PUBLIC . ASSETS_PATH . 'img/');

// define other config
define('COOKIE_LIFE', 1800);  // 30 minutes

if (defined('DEBUG') && (DEBUG === true)) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ini_set('html_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}

/**
 * Redirects this page to a specified URL.
 *
 * @param string $url
 */
function redirect(string $url = null)
{
    // Remove all illegal characters from a url
    $redirect = filter_var(URI_PUBLIC . $url, FILTER_SANITIZE_URL);

    // Validate url
    if (!filter_var($redirect, FILTER_VALIDATE_URL) === false) {
        header('Location: ' . $redirect);
        exit;
    }
    return false;
}

/**
 * Returns the current relative URI.
 *
 * @return string
 */
function currentUri()
{
    // Get the current Request URI
    $uri = rawurldecode($_SERVER['REQUEST_URI']);

    // Don't take query params into account on the URL
    if (strstr($uri, '?')) {
        $uri = substr($uri, 0, strpos($uri, '?'));
    }

    // Remove trailing slash + enforce a slash at the start
    return '/' . trim($uri, '/');
}

/**
 * Returns sanitized string.
 *
 * @return string
 */
function sanitize(string $str)
{
    return htmlentities(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}
