<?php

namespace BaseFrame\App\Controller;

use BaseFrame\System\Core\Controller;

class Example extends Controller
{
    public function index()
    {
        $this->view("example");
    }
}
