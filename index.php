<?php

include 'myDb.class.php';
include 'user.class.php';
$user = new user();
if ($user->is_login())
    $url = './chat.php';
else
    $url = 'new.php';
header('Location: ' . $url);
