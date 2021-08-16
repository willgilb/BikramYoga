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
use function redirect;
use function sanitize;

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
        // checkinput after form submit (POST request)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // check if csrf_token exists
            if (filter_has_var(INPUT_POST, 'csrf_token')) {

                // sanitize csrf_token value
                $this->csrf_token = sanitize(filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_STRING));

                // redirect to login if csrf_token is invalid
                if ($this->csrf->validateToken($this->csrf_token) === false) {
                    redirect('register');
                }
            }

            // check if username exists
            if (filter_has_var(INPUT_POST, 'username')) {

                // sanitize username value
                $this->username = sanitize(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));

                // set error if username is empty
                if (empty($this->username)) {
                    $this->error['username'] = 'No username was given';
                }

                // check if username is free to register
                if ($this->username && $this->user->byUsername($this->username)) {
                    $this->error['username'] = 'Please choose a different username';
                }

                // set error is username length is less then 2 chars
                if ($this->username && strlen($this->username) < 2) {
                    $this->error['username'] = 'Username must contain at least 2 characters';
                }

                // set error is username length is more then 15 chars
                if ($this->username && strlen($this->username) > 15) {
                    $this->error['username'] = 'Username must contain no more then 15 characters';
                }
            }

            // check if email exists
            if (filter_has_var(INPUT_POST, 'email')) {

                // sanitize email value
                $this->email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

                // set error if email is empty
                if (empty($this->email)) {
                    $this->error['email'] = 'No email was given';
                }

                // check if email contains a valid emailadres
                if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->error['email'] = 'Enter a valid emailadres';
                }
            }

            // check if password exists
            if (filter_has_var(INPUT_POST, 'password')) {

                // sanitize password value
                $this->password = sanitize(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

                // set error if password is empty
                if (empty($this->password)) {
                    $this->error['password'] = 'No password was given';
                }

                // set error if password length is less then 6 chars
                if ($this->password && strlen($this->password) < 6) {
                    $this->error['password'] = 'Password must contain at least 6 characters';
                }
            }

            // check if password_repeat exists
            if (filter_has_var(INPUT_POST, 'password_repeat')) {

                // sanitize password_repeat value
                $this->password_repeat = sanitize(filter_input(INPUT_POST, 'password_repeat', FILTER_SANITIZE_STRING));

                // set error if password_repeat is empty
                if (empty($this->password_repeat)) {
                    $this->error['password_repeat'] = 'No password repeat was given';
                }

                // set error if password_repeat length is less then 6 chars
                if ($this->password && strlen($this->password_repeat) < 6) {
                    $this->error['password_repeat'] = 'Password must contain at least 6 characters';
                }
            }

            // check if password and password_repeat are the same
            if ($this->password && $this->password_repeat && strcmp($this->password, $this->password_repeat) !== 0) {
                $this->error['password_repeat'] = 'Passwords do not match';
                $this->password = null;
                $this->password_repeat = null;
            }

            // check if errors is empty
            if (empty($this->error)) {
                // store the new user registration
                if ($this->storeUser()) {
                    // yeah stored fucking successfull
                    redirect('register_success');
                } else {
                    // fuck, something went wrong
                    $this->debug['add_user'] = 'Error';
                }
            }
        }

        // if not $_POST we display the login form
        $this->displayForm();
    }
}
