<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$friends = $m->rproxy->friends;

$email = $_SESSION['email'];
$friend = $_POST['friend'];

$data = array('email' => $email, 'friend' => $friend);
$friends->insert($data);

if ($data['_id']) {
    echo "ok";
} else {
    echo "fail";
}

?>