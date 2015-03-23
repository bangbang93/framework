<?php
/**
 * Created by PhpStorm.
 * User: bangbang
 * Date: 15/03/24
 * Time: 0:24
 */
$app->get('/', function (){
    echo 'user page';
});
$app->get('/register', function (){
    echo 'register page';
});