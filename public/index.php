<?php
//bootstrap
$config = require_once '../config/config.php';
$config['db'] = require_once '../config/database.php';
require_once '../vendor/autoload.php';

//init config
$appConfig = [];
$appConfig['mode'] = $config['mode'];
$appConfig['templates.path'] = '../view';
$appConfig['view'] = new \Slim\Views\Twig();

//init slim
$app = new \Slim\Slim($appConfig);
session_start();


//setup db
require_once '../models/BaseModel.php';
BaseModel::init($config['db']);


//setup env
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

//setup router
require_once '../route/route.php';

$app->get('/', function () use ($app){
    $app->render('index.html', [
        'word'=>'Hello, World!'
    ]);
});

$app->run();