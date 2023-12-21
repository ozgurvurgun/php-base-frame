<?php

namespace CompartSoftware\App\Controller;

use CompartSoftware\App\Controller\Helpers\ExampleHelpers;
use CompartSoftware\System\Core\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        $ExampleController = new ExampleHelpers;
        $this->view('main');
    }
}
