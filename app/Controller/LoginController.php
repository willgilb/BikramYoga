<?php

declare(strict_types=1);

namespace Controller;

use Core\CSRF;
use Core\View;
use Model\User;
use Core\Session;
use Core\Database;
use Model\AuthUser;

use function redirect;
use function sanitize;
use function filter_input;
use function filter_has_var;

class LoginController
{
    public ?string $username = null;
    public ?string $password = null;
    public ?string $csrf_token = null;
    public ?array $error = null;
    public ?array $debug = null;

    protected object $auth;
    protected object $csrf;
    protected object $db;
    protected object $user;
    protected object $session;
    protected object $view;

    public function __construct()
    {
        $this->auth = new AuthUser;
        $this->csrf = new CSRF;
        $this->db = new Database;
        $this->user = new User;
        $this->session = new Session;
        $this->view = new View;
    }

    public function displayForm()
    {
        $data = [
            'error' => $this->error,
            'username' => $this->username,
            'password' => $this->password,
            'csrf' => $this->csrf,
            'debug' => $this->debug,
        ];

        $this->view->render('login', $data);
    }

    public function processInput()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize and validate csrf_token
            if (filter_has_var(INPUT_POST, 'csrf_token')) {

                $this->csrf_token = sanitize(filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING));

                // redirect to login if csrf_token is invalid
                if ($this->csrf->validateToken($this->csrf_token) === false) {
                    redirect('login');
                }
            }

            // sanitize and validate username
            if (filter_has_var(INPUT_POST, 'username')) {

                $this->username = sanitize(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));

                if (empty($this->username)) {
                    $this->error['username'] = 'No username was given';
                }
            }

            // sanitize and validate password
            if (filter_has_var(INPUT_POST, 'password')) {

                $this->password = sanitize(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

                if (empty($this->password)) {
                    $this->error['password'] = 'No password was given';
                }
            }

            $validate = $this->auth->validatePassword($this->username, $this->password);

            if ($this->username && $this->password && $validate === false) {
                $this->error['validation'] = 'Wrong login credentials dummy, try again';
            }

            // make sure there a no errors
            if (empty($this->error)) {
                $this->session->set('auth_user', $this->user->byUsername($this->username));
                redirect();
            }
        }

        // if not $_POST we display the login form
        $this->displayForm();
    }
}
