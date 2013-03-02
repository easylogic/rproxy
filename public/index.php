<?php 

include_once "lib.php";
session_start();


$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;

$list = $proxy->find(array('type' => 'public'))->sort(array('_id' => -1));


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>RProxy to connecting server</title>
    	<?php include_once "resource.php" ?>        
    </head>
    <body>
    <?php include_once "header.php"; ?>

    <div class='container'>
        <div class='page-header'>
            <h1>Public Proxy Lists</h1>
        </div>
        
        <div class='row'>
            <div class='span4'>
                <h3>New 20</h3>
                
                <?php foreach($list as $data) {     ?> 
                    <div class='alert fade in'>
                          <strong><a href="/myproxy_view.php?id=<?php echo $data['_id'] ?>"><?php echo $data['title'] ?></a></strong>
                          <div>
                              <a href='/myproxy.php?email=<?php echo $data['email'] ?>'><span class='label label-info'><?php echo $data['email'] ?></label></a>
                          </div>
                          
                    </div>  
                <?php } ?>  
                <a href='#'>more ...</a>              
            </div>
            <div class='span4'>
                <h3>Top 20</h3>
                <a href='#'>more ...</a>
            </div>
            
            <div class='span4'>
                <h3>Recommend 20</h3>
                <a href='#'>more ...</a>
            </div>                      
        </div>


    </div>
    </body>
</html>
