<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myDb
 *
 * @author liuguang
 */
class myDb {

    private static $db_Obj = NULL;
    private $pdo;

    public static function conn() {
        if (self::$db_Obj == NULL)
            self::$db_Obj = new myDb();
        return self::$db_Obj;
    }

    private function __construct() {
        $db_host = 'localhost';
        $db_port = 3306;
        $db_user = 'root';
        $db_pass = 'root';
        $db_name = 'test';
        $dsn = 'mysql:host=' . $db_host . ';port=' . $db_port . ';dbname=' . $db_name;
        try {
            $this->pdo = new PDO($dsn, $db_user, $db_pass);
            $this->pdo->exec('SET NAMES utf8');
        } catch (PDOException $exc) {
            die($exc->getMessage());
        }
    }

    public function exec($sql) {
        $this->pdo->exec($sql);
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

}
