<?php

declare(strict_types=1);

namespace Controller;

use Core\Session;
use Core\View;

class HomeController
{

    protected object $session;
    protected object $view;

    public function __construct()
    {
        $this->session = new Session;
        $this->view = new View;
    }

    public function showIndex()
    {
        $auth_user = $this->session->get('auth_user');

        $data = [
            'user_name' => $auth_user->username,
            'user_role' => $auth_user->role,
            'user_perm' => json_decode($auth_user->perms)
        ];

        $this->view->render('home', $data);
    }
}
