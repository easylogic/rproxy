<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy_view = $m->rproxy->proxy_view;

$email = $_SESSION['email'];

$data = array(
	'_id' => new MongoId($_POST['id']),
    'email' => $email
);

$proxy_view->remove($data);


    echo "ok";
?>