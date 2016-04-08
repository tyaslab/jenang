<?php

namespace Jenang\Controller\Api;

use Jenang\Controller\BaseController;

class BaseApiController extends BaseController {
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
