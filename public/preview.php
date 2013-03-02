<?php

session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;
$proxy_view = $m->rproxy->proxy_view;

$email = $_SESSION['email'];
$values = array_map(function($value) { return new MongoId($value); }, $_POST['values']);

$proxy_list = $proxy->find(array('_id' => array(
    '$in' => $values
)))->sort(array(
    '_id' => -1
));

$proxy_data = $proxy_view->find(array('title_id' => array(
    '$in' => $values
)))->sort(array(
    '_id' => -1
));

$temp = array();

foreach($proxy_list as $data) {
    $data['_id'] .= "";
    $data['list'] = array();
    $temp[strval($data['_id'])] = $data;
}

foreach($proxy_data as $view) {
    $view['_id'] .= "";    
    $view['title_id'] .= "";    
    $temp[strval($view['title_id'])]['list'][] = $view;
}

header('Content-Type: application/json');
echo json_encode($temp);

?>