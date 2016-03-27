<?php

namespace Jenang\Controller\API;

use Jenang\Controller\BaseController;

class BaseAPIController extends BaseController {
    protected $error_message = [];

    protected function immediateResponse($status) {
        header("Content-Type: application/json");
        http_response_code($status);
        exit();
    }

    protected function dehydrate($data) {
        return $data;
    }
}
