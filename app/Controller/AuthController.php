<?php

declare(strict_types=1);

namespace Controller;

use Core\Session;
use Core\View;
use Model\AuthUser;

class AuthController
{
    protected object $session;
    protected object $view;
    protected object $auth;

    public function __construct()
    {
        $this->session = new Session;
        $this->view = new View;
        $this->auth = new AuthUser;
    }

    function isLoggedIn()
    {
        $currentUri = currentUri();
        $isLoggedIn = $this->auth->isLoggedIn();

        // root url check
        if ($currentUri === '/') {
            if ($isLoggedIn === false) {
                redirect('login');
            }
        }
        // login url check
        if ($currentUri === '/login') {
            if ($isLoggedIn === true) {
                redirect();
            }
        }
    }

    function logOut()
    {
        $this->session->remove('auth_user');
        redirect();
    }
}
