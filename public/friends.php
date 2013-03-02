<?php 
session_start();

$m = new Mongo("mongodb://youngman.kr");
$friends = $m->rproxy->friends;

$email = $_SESSION['email'];

$following = $friends->find(array('email' => $email))->sort(array(
	'friend' => 1
));

$follower = $friends->find(array('friend' => $email))->sort(array(
    'email' => 1
));

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>RProxy to connecting server</title>


        <?php include_once "resource.php" ?>
    <script type="text/javascript">
        function create() {
            var friend = $("#friend").val();
            
            $.post('/create_friends.php', { friend : friend }, function(res) {
                if (res == 'ok') {
                	location.reload();
                }
            })
        }
    </script>
    </head>
    <body>

    <?php include_once "header.php"; ?>

    <div class='container'>
        <div class='page-header'>
            <h1>My Friends</h1>
        </div>
        
        <div class='row'>
            <div class='span6'>
                
              <h3>Following <lable class='badge badge-warning'><?php echo $following->count() ?></lable></h3>
              <?php foreach($following as $data) { ?> 
                <div class='alert'>
                    <a href='/myproxy.php?email=<?php echo $data['friend'] ?>'><?php echo $data['friend'] ?></a>
                    <a href='#' class='pull-right btn btn-mini btn-primary'><i class='icon-ok icon-white'></i></a>
                </div>
              <?php } ?>                                            
                
                
            </div>
            <div class='span6'>
                <h3>Follower <lable class='badge badge-warning'><?php echo $follower->count() ?></lable></h3>
                
                  <?php foreach($follower as $data) { ?> 
                    <div class='alert'>
                        <a href='/myproxy.php?email=<?php echo $data['friend'] ?>'><?php echo $data['friend'] ?></a>
                        <a href='#' class='pull-right btn btn-mini'><i class='icon-plus'></i></a>
                        
                    </div>
                  <?php } ?>                    
            </div>
        </div>
        
    </div>
    </body>
</html>
