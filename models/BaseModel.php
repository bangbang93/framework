<?php
/**
 * Created by PhpStorm.
 * User: bangbang
 * Date: 15/03/24
 * Time: 11:55
 */

abstract class BaseModel {
    protected $table;

    public static $pdo;
    protected static $config;
    protected $pdoStmt;
    public function __construct($config = null){
        if (empty($config)){
            if (self::$pdo == null){
                throw new PDOException('no database connected');
            } else {
            }
        } else {
            self::$pdo = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['password']);
        }
    }

    static public function init($config){
        self::$config = $config;
        self::$pdo = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['password']);
    }
}