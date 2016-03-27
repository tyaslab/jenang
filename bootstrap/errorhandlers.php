<?php

$c['errorHandler'] = function($c) {
    return new \Slim\Handlers\Error($c->debug);
};
