<?php

declare(strict_types=1);

namespace Controller;

use Controller\BaseController;

class ExampleController extends BaseController
{

    public function showIndex()
    {
        $data = [
            'welcome' => 'Hi there stranger'
        ];

        $this->view->render('home', $data);
    }
}
