<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author liuguang
 */
class user {

    private $is_login;
    private $userInfo;

    public function __construct() {
        if (empty($_COOKIE['ssid'])) {
            $this->is_login = FALSE;
            $this->userInfo = array();
        } else {
            $db = myDb::conn();
            $ssid = addslashes($_COOKIE['ssid']);
            $res = $db->query('SELECT COUNT(*) FROM online WHERE sid=\'' . $ssid . '\'');
            $tmp = $res->fetch();
            if ($tmp['COUNT(*)'] == 0) {
                $this->is_login = FALSE;
                $this->userInfo = array();
            } else {
                $this->is_login = TRUE;
                $res = $db->query('SELECT * FROM online WHERE sid=\'' . $ssid . '\' LIMIT 1');
                $this->userInfo = $res->fetch();
                $res = NUll;
            }
        }
    }

    public function is_login() {
        return $this->is_login;
    }

    public function getUserInfo() {
        return $this->userInfo;
    }

}
