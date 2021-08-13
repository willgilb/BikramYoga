<?php

ini_set('default_charset', 'UTF-8');
date_default_timezone_set(TIMEZONE);
setlocale(LC_ALL, LOCALE);

// define some paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('ABS_PATH', dirname(__DIR__));
define('APP_PATH', ROOT . DS . 'app');
define('VIEWS_DIR', APP_PATH . DS . 'View' . DS);

// public paths
define('ASSETS_PATH', 'assets/');
define('CSS_PATH', URI_PUBLIC . ASSETS_PATH . 'css/');
define('JS_PATH', URI_PUBLIC . ASSETS_PATH . 'js/');

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
