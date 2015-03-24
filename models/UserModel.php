<?php
/**
 * Created by PhpStorm.
 * User: bangbang
 * Date: 15/03/24
 * Time: 12:03
 */

class UserModel extends BaseModel{
    public function __construct(){
        parent::__construct();
        $this->table = self::$config['prefix'].'users';
    }

    public function getUserByUid($uid){
        $stmt = $this->pdoStmt = self::$pdo->prepare("SELECT * FROM $this->table WHERE `uid` = :uid");
        $stmt->execute([':uid'=>$uid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($nickname, $password, $email, $phone, $realname){
        $stmt = $this->pdoStmt = self::$pdo->prepare("INSERT INTO $this->table (`nickname`, `password`, `email`, `phone`, `realname`) VALUES (:nickname, :password, :email, :phone, :realname)");
        $stmt->execute([
            ':nickname'=>$nickname,
            ':password'=>$password,
            ':email'=>$email,
            ':phone'=>$phone,
            ':realname'=>$realname
        ]);
        if ($stmt->errorCode()!= '00000'){
            throw new Exception($stmt->errorInfo());
        }
    }

    public function getUserByEmail($email){
        $stmt = $this->pdoStmt = self::$pdo->prepare("SELECT * FROM $this->table FROM `email` = :email");
        $stmt->execute([':email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($uid, $field, $value = null){
        if (!is_array($field)){
            $old_field = $field;
            $field = [];
            $field[$old_field] = $value;
        }
        $stmt = $this->pdoStmt = self::$pdo->prepare("UPDATE $this->table SET ");
    }
}