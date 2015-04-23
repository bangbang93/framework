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
        $stmt = $this->select(['uid'=>$uid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByPhone($phone){
        $stmt = $this->select(['phone'=>$phone]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email){
        $stmt = $this->select( ['email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUser($method, $value){
        if (!in_array(strtolower($method), ['uid', 'phone', 'email', 'id']));
        $method = 'getUserBy'.ucfirst($method);
        return $this->$method;
    }

    public function add($nickname, $password, $email, $phone, $realname){
        $stmt = $this->insert([
            'nickname'=>$nickname,
            'password'=>md5(md5($password).self::$config['passwordSalt']),
            'email'=>$email,
            'phone'=>$phone,
            'realname'=>$realname
        ]);
        return $stmt->errorCode() == '00000';
    }

    public function update($uid, $field, $value = null){
        if (is_string($field)){
            $old_field = $field;
            $field = [];
            $field[$old_field] = $value;
        }
        $stmt = parent::update($field, ['uid'=>$uid]);
        return $stmt->rowCount();
    }

    public function getById($id)
    {
        return $this->getUserByUid($id);
    }
}