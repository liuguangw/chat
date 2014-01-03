<?php

include '../myDb.class.php';
include '../user.class.php';
$result = array('error' => 0, 'msg' => '');
$user = new user();
if (!$user->is_login()) {
    $result['error'] = 1;
    $result['msg'] = '<p style="color:red;">你没有设置昵称，或者设置超时,<a href="new.php">点击这里设置</a></p>';
} else {
    $msg = addslashes(htmlspecialchars(trim($_POST['msg'])));
    if ($msg != '') {
        $user_info = $user->getUserInfo();
        $nickname = addslashes($user_info['nickname']);
        $post_time = time();
        $db=  myDb::conn();
        $sql = "INSERT INTO msg(nickname,msg,post_time) VALUES ('{$nickname}','{$msg}',{$post_time})";
        $db->exec($sql);
    } else {
        $result['error'] = 1;
        $result['msg'] = '<p style="color:red;">不能发空消息</p>';
    }
}
header('Content-Type:application/json;charset=utf-8');
echo json_encode($result);
