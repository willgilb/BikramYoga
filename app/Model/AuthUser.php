<?php

declare(strict_types=1);

namespace Model;

use Core\Session;
use Model\User;
use Exception;

use function hash_hmac;
use function password_hash;
use function password_verify;
use function substr;
use function str_shuffle;

class AuthUser
{
    protected string $pepper;
    protected object $session;

    public ?string $username = null;
    public ?string $email = null;
    public ?string $pwhash = null;
    private object $user;

    public function __construct()
    {
        $this->session = new Session;
        $this->user = new User;
        $this->pepper = getenv('AUTHENTICATION_PEPPER');
    }

    /**
     * Is a user logged in or not?
     *
     * @return boolean True when logged in, otherwise false.
     */
    public function isLoggedIn(): bool
    {
        $auth_user = $this->session->get('auth_user');
        return (isset($auth_user) && $auth_user !== null) ? true : false;
    }

    /**
     * Generates a password.
     *
     * @param int  $length          Password length, defaults to 8 chars)
     * @return string               The password
     */
    function random_password(int $length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    /**
     * Generates a hashed version of a password.
     *
     * @param  string  $password   A given password
     * @return string|exception    Hashed string or Exception
     */
    public function generateHashedPassword(string $password): string
    {
        if (!empty($this->pepper)) {
            $hash = hash_hmac("sha256", $password, $this->pepper);
            return password_hash($hash, PASSWORD_BCRYPT);
        }

        return false;
        //throw new Exception('AUTHENTICATION_PEPPER is missing or empty');
    }

    /**
     * Validates a given password for a given user.
     *
     * @param  string  $username  Username to validate password against.
     * @param  string  $password  Password to validate.
     * @return boolean            True when valid else false, 
     */
    public function validatePassword(string $username, string $password): bool
    {
        $user = $this->user->byUsername($username);
        if ($user) {
            $hash = hash_hmac('sha256', $password, $this->pepper);
            return password_verify($hash, $user->pwhash);
        }
        return false;
    }
}
