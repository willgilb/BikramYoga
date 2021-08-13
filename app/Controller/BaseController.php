<?php

declare(strict_types=1);

namespace Controller;

use Core\View;
use Core\Database;

class BaseController
{
    protected object $view;
    protected object $db;

    public function __construct()
    {
        $this->view = new View;
        $this->db = new Database;
    }
}
