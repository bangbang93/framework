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

    const PDO_NO_ERROR = '00000';

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

    /**
     * @param $config
     */
    static public function init($config){
        self::$config = $config;
        self::$pdo = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['password']);
    }

    /**
     * @param array $data
     * @return PDOStatement
     */
    public function insert(array $data){
        $col = [];
        $placeholder = [];
        $value = [];
        foreach ($data as $k=>$v){
            $col[] = $k;
            $value[] = $v;
            $placeholder[] = '?';
        }
        $sql = "INSERT INTO $this->table (`".implode('`,`', $col)."`) VALUES (".implode(',', $placeholder).")";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($value);
        return $stmt;
    }

    /**
     * @param $col |$data
     * @param array $data
     * @return PDOStatement
     */
    public function select($col = '*', array $data = null){
        if ($data == null){
            $data = $col;
            $col = '*';
        }
        if (!is_array($col)){
            $col = [$col];
        }

        $sql = "SELECT `".implode('`,`', $col)."` FROM `$this->table`";
        $value = [];
        if (!empty($data)){
            $where = [];
            foreach($data as $k=>$v){
                $value[] = $v;
                $where[] = "`$k` = ?";
            }
            if (!empty($where))
                $sql .= implode(' AND ', $where);
        }
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($value);
        return $stmt;
    }

    /**
     * @param $col |$data
     * @param array $data
     * @return string
     */
    public function count($col = '*', array $data = null){
        if (is_array($col)){
            $data = $col;
            $col = '*';
        }
        $sql = "SELECT count($col) FROM `$this->table`";
        $value = [];
        if (!empty($data)){
            $where = [];
            foreach($data as $k=>$v){
                $value[] = $v;
                $where[] = "`$k` = ?";
            }
            if (!empty($where))
                $sql .= implode(' AND ', $where);
        }
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($value);
        return $stmt->fetchColumn();
    }

    /**
     * @param array $data
     * @param array $where
     * @return PDOStatement
     */
    public function update(array $data, array $where = null){
        $sql = "UPDATE `$this->table` SET ";
        $col = [];
        $value = [];
        foreach($data as $k=>$v){
            $value[] = $v;
            $col[] = "`$k` = ?";
        }
        $sql .= implode(',', $col);
        if (!empty($where)){
            $sql .= ' WHERE ';
            $col = [];
            foreach($where as $k=>$v){
                $value[] = $v;
                $col[] = "`$k` = ?";
            }
            $sql .= implode(' AND ', $col);
        }
        $stmt = $this->pdoStmt = self::$pdo->prepare($sql);
        $stmt->execute($value);
        return $stmt;
    }

    abstract public function getById($id);
}