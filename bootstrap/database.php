<?php

// TODO: Local Settings
use Illuminate\Database\Capsule\Manager as Capsule;

$db_list = [
    'local' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'viceban',
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
    ],
    'server' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'tyaslabc_vicebanapi',
        'username'  => 'tyaslabc_viceban',
        'password'  => '4kucint4k4mu',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
];

$db_key = 'local';

if (gethostname() == 'poseidon.hideserver.net')
    $db_key = 'server';

$capsule = new Capsule;
$capsule->addConnection($db_list[$db_key], 'default');

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();