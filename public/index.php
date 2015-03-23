<?php
$config = require_once '../config/config.php';
require_once '../vendor/autoload.php';


$app_config = [];
$app_config['mode'] = $config['mode'];
$app_config['templates.path'] = '../view';
$app_config['view'] = new \Slim\Views\Twig();


$app = new \Slim\Slim($app_config);
require_once '../route/route.php';


$app->configureMode('development', function () use ($app){
    $app->config([
        'debug'=>true
    ]);
    $app->view()->parserOptions = [
        'debug'=>true
    ];
});

$app->configureMode('production', function () use ($app){
    $app->view()->parserOptioins = [
        'debug'=>false,
        'cache'=>realpath(__DIR__.'/../cache')
    ];
});

$app->get('/', function () use ($app){
    $app->render('index.html', [
        'word'=>'Hello, World!'
    ]);
});

$app->run();