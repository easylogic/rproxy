<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;

$email = $_SESSION['email'];
$title = $_POST['title'];
$type = $_POST['type'];  // default, global

$data = array('email' => $email, 'title' => $title, 'type' => $type);	

$proxy->insert($data);

if ($data['_id']) {
    echo "ok";
} else {
    echo "fail";
}

?>