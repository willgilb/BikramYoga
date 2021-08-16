<?php

declare(strict_types=1);

namespace Core;

use function extract;

class View
{
    function render(string $view, array $data = [])
    {
        extract($data);
        require(VIEWS_DIR . $view . '.php');
    }
}
