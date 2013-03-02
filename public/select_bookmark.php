<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$bookmark = $m->rproxy->bookmark;

$email = $_SESSION['email'];
$id = new MongoId($_POST['id']);

if (!$email) {
    echo "fail";
    exit;
}

$data = array(
    'email' => $email,
    '_id' => $id
);

$data = $bookmark->findOne($data);

$data['_id'] .= "";
foreach ($data['values'] as &$value) {
    $value .= "";
}

header('Content-Type: application/json');
echo json_encode($data);

?>