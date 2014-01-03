<?php

date_default_timezone_set('PRC');
include '../myDb.class.php';
include '../user.class.php';
$newmsg = 0;
$msg = '';
$db = myDb::conn();
$update_time = time();
$sid = $_COOKIE['ssid'];
$db->exec("UPDATE online SET update_time='{$update_time}' WHERE sid='{$sid}'");
$msg_id_input =(int)$_POST['msg_id'];
if ($msg_id_input == 0) {
    $res = $db->query("SELECT MAX(msg_id) FROM msg");
    $tmp = $res->fetch();
    $res = NULL;
    $msg_id_input=(int)$tmp['MAX(msg_id)'];
}
$msg_id_output = $msg_id_input;
for ($i = 0; $i < 10; $i++) {
    $res = $db->query("SELECT COUNT(*) FROM msg where msg_id>" . $msg_id_input);
    $tmp = $res->fetch();
    $res = NULL;
    $newmsg = $tmp['COUNT(*)'];
    if ($newmsg != 0) {
        $res = $db->query("SELECT * FROM msg ORDER BY msg_id DESC LIMIT " . $newmsg);
        while ($tmp = $res->fetch()) {
            $tmp_msg = '<p style="border-style:solid;border-width: 1px;border-color: green;">' . $tmp['nickname'] . ' ' . date('Y-m-d G:i:s', $tmp['post_time']) . '<br />';
            $tmp_msg.=($tmp['msg'] . '</p>');
            $msg = $tmp_msg . $msg;
            $msg_id_output+=1;
        }
        break;
    }
    sleep(2);
}
$result = array('newmsg' => $newmsg, 'msg_id' => $msg_id_output, 'msg' => $msg);
header('Content-Type:application/json;charset=utf-8');
echo json_encode($result);
