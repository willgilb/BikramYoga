<?php

declare(strict_types=1);

namespace Controller;

use Core\View;

class ErrorController
{

    protected object $view;

    public function __construct()
    {
        $this->view = new View;
    }

    public function notFound()
    {
        $data = [
            'title' => 'Resource not found'
        ];

        $this->view->render('404', $data);
    }
}
