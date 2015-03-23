<?php
$config = require_once '../config/config.php';
require_once '../vendor/autoload.php';


$app_config = [];
$app_config['mode'] = $config['mode'];
$app_config['templates.path'] = '../templates';


$app = new \Slim\Slim($app_config);
require_once '../route/route.php';


$app->configureMode('development', function () use ($app){
    $app->config([
        'debug'=>true
    ]);
});

$app->get('/', function (){
    echo 'Hello, World!';
});
$app->run();