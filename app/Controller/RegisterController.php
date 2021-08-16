<?php

declare(strict_types=1);

namespace Controller;

use Core\CSRF;
use Core\View;
use Core\Database;
use Model\User;
use Model\AuthUser;

use function filter_has_var;
use function filter_input;
use function trim;


class RegisterController
{
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_repeat = null;
    public ?string $csrf_token = null;

    public ?array $error = null;
    public ?array $debug = null;

    protected object $auth;
    protected object $csrf;
    protected object $db;
    protected object $user;
    protected object $view;

    public function __construct()
    {
        $this->auth = new AuthUser;
        $this->csrf = new CSRF;
        $this->db = new Database;
        $this->user = new User;
        $this->view = new View;
    }

    public function displayForm()
    {
        $data = [
            'error' => $this->error,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'password_repeat' => $this->password_repeat,
            'csrf' => $this->csrf,
            'debug' => $this->debug,
        ];

        $this->view->render('register', $data);
    }

    public function storeUser()
    {
        $user = $this->user;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->pwhash = $this->auth->generateHashedPassword($this->password);
        $user->role_id = 3;
        return $user->insertUser();
    }

    public function processInput()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (filter_has_var(INPUT_POST, 'csrf_token')) {
                $this->csrf_token = trim(filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING));
                htmlentities($this->csrf_token, ENT_QUOTES, 'UTF-8');

                // redirect to login if csrf_token is invalid
                if ($this->csrf->validateToken($this->csrf_token) === false) {
                    redirect('register');
                }
            }

            // sanitize and validate username
            if (filter_has_var(INPUT_POST, 'username')) {
                $this->username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
                htmlentities($this->username, ENT_QUOTES, 'UTF-8');

                if (empty($this->username)) {
                    $this->error['username'] = 'No username was given';
                }
            }

            // sanitize and validate email
            if (filter_has_var(INPUT_POST, 'email')) {
                $this->email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                htmlentities($this->email, ENT_QUOTES, 'UTF-8');

                if (empty($this->email)) {
                    $this->error['email'] = 'No email was given';
                }
            }

            // sanitize and validate password
            if (filter_has_var(INPUT_POST, 'password')) {
                $this->password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
                htmlentities($this->password, ENT_QUOTES, 'UTF-8');

                if (empty($this->password)) {
                    $this->error['password'] = 'No password was given';
                }
            }

            // sanitize and validate password
            if (filter_has_var(INPUT_POST, 'password_repeat')) {
                $this->password_repeat = trim(filter_input(INPUT_POST, 'password_repeat', FILTER_SANITIZE_STRING));
                htmlentities($this->password_repeat, ENT_QUOTES, 'UTF-8');

                if (empty($this->password_repeat)) {
                    $this->error['password_repeat'] = 'No password repeat was given';
                }
            }

            if ($this->password && $this->password_repeat && strcmp($this->password, $this->password_repeat) !== 0) {
                $this->error['password_mismatch'] = 'Passwords do not match';
                $this->password = null;
                $this->password_repeat = null;
            }

            if (empty($this->error)) {

                $byUsername = $this->user->byUsername($this->username);

                if (!$byUsername && $this->storeUser()) {
                    $this->debug['insert_user'] = 'Success';
                } else {
                    $this->debug['insert_user'] = 'Error';
                }
            }
        }

        // if not $_POST we display the login form
        $this->displayForm();
    }
}
