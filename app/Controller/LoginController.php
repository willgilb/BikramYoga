<?php

declare(strict_types=1);

namespace Controller;

use Core\CSRF;
use Core\View;
use Model\User;
use Core\Session;
use Core\Database;
use function trim;

use Model\AuthUser;
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

        $auth_user = $this->session->get('auth_user');
        if (isset($auth_user)) {
            var_dump($auth_user);
        }

        //var_dump($this->user);
        //var_dump($this->password);
        //var_dump($this->auth->validatePassword($this->user, $this->password));
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

    public function sanitizeInput()
    {
        if (filter_has_var(INPUT_POST, 'username')) {
            $this->username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        }
        if (filter_has_var(INPUT_POST, 'password')) {
            $this->password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
        }
        if (filter_has_var(INPUT_POST, 'csrf_token')) {
            $this->csrf_token = trim(filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING));
        }

        // for reference only: currently not used
        if (filter_has_var(INPUT_GET, 'id')) {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            if ($id === false) {
                // handle error
            }
        }
    }

    public function validateInput()
    {
        if ($this->csrf->validateToken($this->csrf_token) === false) {
            redirect('login');
        }
        if (empty($this->username)) {
            $this->error['username'] = 'No username was given';
        }
        if (empty($this->password)) {
            $this->error['password'] = 'No password was given';
        }

        if (!empty($this->username) && !empty($this->password) && !$this->user->byUsername($this->username)) {
            $this->error['username'] = 'Wrong login credentials dummy, try again';
        }
    }

    public function processInput()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->sanitizeInput();
            $this->validateInput();

            if (empty($this->error)) {
                
                $validate = $this->auth->validatePassword($this->username, $this->password);
                $byUsername = $this->user->byUsername($this->username);

                if ($validate && $byUsername) {
                    $this->session->set('auth_user',  $byUsername);
                    redirect();
                } else {
                    redirect('login');
                }
            }
        }
        $this->displayForm();
    }
}
