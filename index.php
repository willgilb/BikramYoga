<?php

declare(strict_types=1);

use Core\Router;

require_once 'config.php';
require_once 'bootstrap.php';
require_once 'autoload.php';

$router = new Router();

$router->setNamespace('\Controller');
$router->set404('ErrorController@notFound');

// before middleware routes
$router->before('GET', '/','AuthController@isLoggedIn');
$router->before('GET', '/login','AuthController@isLoggedIn');

//$router->before('POST', '/login','LoginController@processAuth');

$router->match('GET', '/', 'HomeController@showIndex');
$router->match('GET|POST', '/login', 'LoginController@processInput');
$router->match('GET|POST', '/register', 'RegisterController@processInput');

$router->match('GET', '/logout', 'AuthController@logOut');

$router->run();
