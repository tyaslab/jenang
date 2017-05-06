<?php

namespace Jenang\Controller;

use Slim\Flash\Messages as FlashMessages;
use Slim\Views\PhpRenderer;

class BaseController {
    protected $c;
    private $templates;

    protected $request;
    protected $response;
    protected $args = [];
    protected $context_data = [
        'STATIC_URL' => '/static/',
        'MEDIA_URL' => '/media/'
    ];

    protected $allowed_methods = ['GET', 'POST'];
    protected $user;

    function __construct($c) {
        $this->c = $c;
        $this->templates = new \League\Plates\Engine('../src/App/View');

        $this->templates->registerFunction('arrget', function($arr, $idx, $default=null) {
            return Arr::get($arr, $idx, $default);
        });
    }

    function render($template_path, $data=[]) {
        $data = array_merge($this->context_data, $data);
        $renderer = new \Slim\Views\PhpRenderer('../src/App/View');

        $renderer->render($this->response, $template_path . '.php', $data);
    }

    protected function authentication() {
        
    }

    protected function permission() {
        
    }

    function dispatch($request, $response, $args=[]) {
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

        $this->context_data['request'] = $request;
        $this->context_data['response'] = $response;
        $this->context_data['args'] = $args;
        $this->context_data['user'] = $this->user;
        $this->context_data['method'] = $method;

        $flashMessages = new FlashMessages();
        $this->context_data['message'] = $flashMessages->getMessages();

        return call_user_func_array([$this, strtolower($method)], []);
    }

    protected function getCurrentUser() {
        return null;
    }
}
