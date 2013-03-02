<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy_view = $m->rproxy->proxy_view;

$email = $_SESSION['email'];

$data = array(
    'email' => $email, 
    'title_id' => new MongoId($_POST['title_id']),
    'type' => $_POST['type'],
    'before' => $_POST['before'],
    'after' => $_POST['after'],
    'description' => $_POST['description'],
);

$proxy_view->insert($data);

if ($data['_id']) {
    echo "ok";
} else {
    echo "fail";
}

?>