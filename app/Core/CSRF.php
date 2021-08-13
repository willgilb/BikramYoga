<?php

declare(strict_types=1);

namespace Core;

use Core\Session;

use function bin2hex;
use function random_bytes;

class CSRF
{
    private const TOKEN_NAME = 'csrf_token';

    protected object $session;

    public function __construct()
    {
        $this->session = new Session;
    }

    public function generateToken()
    {
        $this->setToken();
        printf('<input type="hidden" name="csrf_token" value="%s">%s', $this->session->get(self::TOKEN_NAME), PHP_EOL);
    }

    public function setToken()
    {
        $random = bin2hex(random_bytes(32));
        $this->session->set(self::TOKEN_NAME,  $random);
    }

    public function validateToken(string $csrf_token): bool
    {
        $this->session->get(self::TOKEN_NAME);
        return (hash_equals($this->session->get(self::TOKEN_NAME), $csrf_token));
    }
}
