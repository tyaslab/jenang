<?php

namespace App\Controller;

use Jenang\Controller\BaseController;

class HomeController extends BaseController {
    public function get() {
        $this->render('welcome');
    }
}