<?php

declare(strict_types=1);

use Core\Router;

require_once 'autoload.php';
require_once 'bootstrap.php';

$router = new Router();

$router->setNamespace('\Controller');
$router->set404('ErrorController@notFound');

// before middleware routes
$router->before('GET', '/', 'AuthController@isLoggedIn');
$router->before('GET', '/login', 'AuthController@isLoggedIn');

$router->match('GET', '/', 'HomeController@displayIndex');
$router->match('GET|POST', '/login', 'LoginController@processInput');
$router->match('GET|POST', '/register', 'RegisterController@processInput');
$router->match('GET', '/success', 'RegisterController@displaySuccess');

$router->match('GET', '/logout', 'AuthController@logOut');

$router->run();
