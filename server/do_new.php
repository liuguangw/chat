<?php

$result = array();
$result['addnew'] = 0;
$result['herf'] = './chat.php';
$result['msg'] = $_POST['nickname'] . '不能使用';

include '../myDb.class.php';
include '../user.class.php';

function add_new($nickname) {
    $nickname_t = addslashes(htmlspecialchars($nickname));
    $time_t = time();
    $time_exp = $time_t - 300;
    $add_result = array('addnew' => 0, 'msg' => '','ssid'=>'');
    if (strlen($nickname_t) > 30) {
        $add_result['msg'] = '昵称太长了';
        return $add_result;
    }
    $db = myDb::conn();
    $res = $db->query("SELECT COUNT(*) FROM online WHERE nickname='{$nickname_t}' and update_time>{$time_exp}");
    $tmp = $res->fetch();
    if ($tmp['COUNT(*)'] != 0) {
        $add_result['msg'] = '此昵称正在使用中';
        return $add_result;
    }
    $rand_id = $time_t;
    for ($index = 0; $index < 8; $index++) {
        $rand_id.='-';
        $rand_id.=rand(1000, 9999);
    }
    $sid = md5($rand_id);
    $db->exec('INSERT INTO online(sid,nickname,update_time) VALUES ' . "('{$sid}','{$nickname_t}',{$time_t})");
    $add_result['addnew'] = 1;
    $add_result['ssid']=$sid;
    return $add_result;
}

$user = new user();
if ($user->is_login()) {
    $result['addnew'] = 1;
} else {
    $add_result = add_new($_POST['nickname']);
    $result['addnew'] = $add_result['addnew'];
    $result['ssid']=$add_result['ssid'];
    $result['msg'] = $add_result['msg'];
}

header('Content-Type:application/json;charset=utf-8');
echo json_encode($result);
