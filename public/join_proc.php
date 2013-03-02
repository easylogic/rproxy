<?php

$m = new Mongo("mongodb://youngman.kr");
$users = $m->rproxy->users;

$cur = $users->find(array('email' => $_POST['email']));

$count = $cur->count();

if ($count > 0) {
    echo "<script>alert('Email is aleady exists.');history.go(-1);</script>";
    exit;
}
$data = array(
    'email' => $_POST['email'],
    'password' => crypt($_POST['password'], $_POST['email'])
); 

$ret = $users->insert($data);

if ($ret === true) {
    echo "<script>alert('Welcome to join this site.'); location.replace('/');</script>";
} else {
    echo "<script>alert('failed'); history.go(-1); </script>";
    
}

?>