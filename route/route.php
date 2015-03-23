<?php
/**
 * Created by PhpStorm.
 * User: bangbang
 * Date: 15/03/24
 * Time: 0:22
 */
$app->group('/user', function () use ($app){
    require_once 'user.php';
});