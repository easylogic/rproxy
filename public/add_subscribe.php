<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;

$email = $_SESSION['email'];

if (!$email) {
    echo "fail";
    exit;
}

$data = array('email' => $email, 'type' => 'subscribe', 'ref' => new MongoId($_POST['id']) );

$test = $proxy->fineOne($data);

if ($test) {
    echo "fail";
    exit;
}	

$proxy->insert($data);

if ($data['_id']) {
    echo "ok";
} else {
    echo "fail";
}

?>