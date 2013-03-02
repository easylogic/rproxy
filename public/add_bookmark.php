<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$bookmark = $m->rproxy->bookmark;

$email = $_SESSION['email'];
$title = $_POST['title'];
$values = array_map(function($value) { return new MongoId($value); } , $_POST['values']);

if (!$email) {
    echo "fail";
    exit;
}

$data = array(
    'email' => $email,
    'title' => $title,
    'values' => $values
);

$bookmark->insert($data);

if ($data['_id']) {
    echo "ok";
} else {
    echo "fail";
}

?>