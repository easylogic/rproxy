<?php 

$email = $_GET['email'];
$cmd = $_GET['cmd'];

if ($cmd == 'data') {
    $m = new Mongo("mongodb://youngman.kr");
    $proxy = $m->rproxy->proxy;
    $proxy_view = $m->rproxy->proxy_view;
    $bookmark = $m->rproxy->bookmark;
    
    $cur = $proxy->find(array('email' => $email));
    $book = $bookmark->find(array('email' => $email));
    $data = array(
        'proxy' => array(),
        'bookmark' => array()
    );
    
    foreach ($book as $b) {
        $b['_id'] .= "";
        
        foreach ($b['values'] as &$value) {
            $value .= "";
        }
        
        $data['bookmark'][] = $b;
    }
    
    foreach($cur as $d) {
        
        $d['_id'] .= "";
        $d['ref'] .= "";
        $d['list'] = array();
        
        if ($d['type'] == 'subscribe') {
            $proxy_view_list = $proxy_view->find(array(
                'title_id' => new MongoId($d['ref'])
            ));
            
        } else {
            $proxy_view_list = $proxy_view->find(array(
                'title_id' => new MongoId($d['_id'])
            ));
            
        }
        
        foreach ($proxy_view_list as $view) {
            $view['_id'] .= "";
            unset($view['title_id']);
            $d['list'][] = $view;
        }
        
        
        
        $data['proxy'][] = $d;
    }
    
    echo json_encode($data);
}



?>