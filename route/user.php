<?php
/**
 * Created by PhpStorm.
 * User: bangbang
 * Date: 15/03/24
 * Time: 0:24
 */

require_once '../models/UserModel.php';
$users = new UserModel();

$app->get('/', function (){
    echo 'user page';
});
$app->get('/register', function () use ($app){
    $app->render('user/register.html');
});
$app->post('/register', function () use ($app, $users){
    $req = $app->request();
    $username = $req->post('username');
    $password = $req->post('password');
    if (is_numeric($username)){
        $users->add('', $password, '', $username, '');
    } else {
        $users->add('', $password, $username, '', '');
    }
});
$app->get('/list', function () use ($app, $users){

});