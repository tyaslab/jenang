<?php

require "../vendor/autoload.php";

$app = new \Slim\App();

// SET CONTAINER
$c = $app->getContainer();
$c['App\Controller\BaseController'] = function($c) {
    return new App\Controller\BaseController($c);
};

// BOOTSTRAPS
require __DIR__ . '/../bootstrap/settings.php';

if (file_exists(__DIR__ . '/../bootstrap/local_settings.php'))
    require __DIR__ . '/../bootstrap/local_settings.php';
require __DIR__ . '/../bootstrap/errorhandlers.php';
require __DIR__ . '/../bootstrap/database.php';
require __DIR__ . '/../bootstrap/routes.php';

$app->run();