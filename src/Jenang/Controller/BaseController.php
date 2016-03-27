<?php

namespace Jenang\Controller;

class BaseController {
    protected $c;
    private $templates;

    protected $request;
    protected $response;
    protected $args;

    protected $allowed_methods = ['GET', 'POST'];
    protected $user;

    function __construct($c) {
        $this->c = $c;
        $this->templates = new \League\Plates\Engine('../src/App/View');
    }

    function render($template_path, $data=[]) {
        echo $this->templates->render($template_path, $data);
    }

    protected function authentication() {
        
    }

    protected function permission() {
        
    }

    function dispatch($request, $response, $args) {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        $this->user = $this->getCurrentUser();

        $this->authentication();
        $this->permission();

        $allowed_methods = array_filter($this->allowed_methods, "strtoupper");
        $method = $request->getMethod();
        $method_function = strtolower($method);

        if (!in_array($method, $allowed_methods))
            return $this->response->withStatus(501);

        if (!method_exists($this, $method_function))
            throw new \Exception("Class method $method_function not implemented");

        return call_user_func_array([$this, strtolower($method)], []);
    }

    protected function getCurrentUser() {
        return null;
    }
}
