<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$users = $m->rproxy->users;

$data = $users->findOne(array(
    'email' => $_POST['email'],
    'password' => crypt($_POST['password'], $_POST['email'])
));

if (!$data) {
    echo "<script>alert('email is not exists.');history.go(-1);</script>";
    exit;
}


$_SESSION['email'] = $_POST['email'];

echo "<script>alert('Welcom!');location.replace('/');</script>"

?>