<?php
include_once 'lib.php'; 
session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;
$friends = $m->rproxy->friends;

if ($_GET['email']) {
	$email = $_GET['email'];
} else {
	$email = $_SESSION['email'];	
}

if ($email == $_SESSION['email']) {
	$cur = $proxy->find(array('email' => $email))->sort(array(
		'title' => 1
	));
} else {
	$cur = $proxy->find(array(
		'email' => $email, 
		'type' => array(
			'$in' => array('public', 'protected')
		)
	))->sort(array(
		'title' => 1
	));
}


$following = $friends->findOne(array('email' => $_SESSION['email'], 'friend' => $email));


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>RProxy to connecting server</title>
    	<?php include_once "resource.php" ?>      
    	
    <script type="text/javascript">
        function create() {
            var title = $("#title").val();
            var type = $("input[name=type]:checked").val();
            
            $.post('/create_title.php', { title : title, type : type }, function(res) {
                if (res == 'ok') {
                	location.reload();
                }
            })
        }
        
        function share() {
        	location.href = '/share.php'
        }
        
        function view_list(type) {
            if (type == 'all') {
                $('.title').show('fade');
            } else if (type == 'public') {
                $('.title.protected, .title.private').hide('fade');
                $('.title.public').show('fade');
            } else if (type == 'protected') {
                $('.title.public, .title.private').hide('fade');
                $('.title.protected').show('fade');
            } else if (type == 'private') {
                $('.title.protected, .title.public').hide('fade');
                $('.title.private').show('fade');                                
            }
        }
        
	        
    </script>
    </head>
    <body>

    <?php include_once "header.php"; ?>

    <div class='container'>
        <div class='page-header'>
            <h1>
                Proxy 
                <?php if ($_SESSION['email'] != $email) {?> 
                    
                    <?php if ($following['friend']) { ?> 
                    <a href="#" class='btn btn-info'><i class='icon-ok icon-white'></i></a>
                    <?php } else { ?>
                    <a href="#" class='btn'><i class='icon-plus'></i></a>
                    <?php } ?>
                
                <?php } ?>
                
            </h1>
        </div>
        
        <h2><?php echo $email ?></h2>
        
          	<?php if ($_SESSION['email'] == $email) {?>
          
            <form class='form-inline' style='border:1px solid #eee;padding:5px;'>
                
                  <?php foreach ($GLOBALS['PROXY_TYPE'] as $key => $p) { ?>
                  <label class="radio alert-<?php echo $p['color'] ?>" style='border-radius:5px; color:blue; padding:5px;'>
                    <input type="radio" name="type" id="<?php echo $key ?>" value="<?php echo $key ?>" <?php echo ($key == 'private') ? 'checked' : '' ?>/> <?php echo $p['name'] ?>
                  </label>
                  <?php } ?>
                  
                  <input type="text" id="title" placeholder="Input Title" class='input-large' />           
                  <button type='button' class="btn" onclick="create()">
                    <i class='icon-plus'></i> Create
                  </button>
            </form>
            
            <ul class="nav nav-pills">
              <li class='active'><a href="#tab-all" data-toggle="pill" onclick="view_list('all')">All</a></li>
              <?php foreach ($GLOBALS['PROXY_TYPE'] as $key => $p) {?>
              <li><a href="#tab-<?php echo $key ?>" data-toggle="pill" onclick="view_list('<?php echo $key ?>')"><?php echo $p['name'] ?></a></li>
              <?php } ?>
            </ul>                                  
            	    
            <?php } ?>

                  <div class='row listview'>
                    
                      <?php 
                        
                        foreach($cur as $data) { 
                      	     $data['type'] = $data['type'] ?: 'private';
                             
                             if ($data['type'] == 'subscribe') {
                                 
                                 $old_data = $data; 
                                 $target = array(
                                    '$ref' => 'proxy',
                                    '$id' => $data['ref']
                                 );
                                 
                                 $ref = $proxy->getDBRef($target);
                                 
                                 $data = $ref;
                             } 
                             	
						
							if ($email != $_SESSION['email']) {
								if ($data['type'] == 'private') contineu;
							} 
                      ?> 
                      <div class='span12 title <?php echo $data['type'] ?>'>
                      <div class='alert alert-<?php echo $GLOBALS['PROXY_TYPE'][$data['type']]['color'] ?>' style='margin-bottom: 10px'>
                          <?php if ($_SESSION['email'] == $data['email']) {?>
                      		<button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php } else if ($old_data['type'] == 'subscribe') { ?>
                            <div class='badge'>
                                <i class='icon-random'>O</i>
                            </div>    
                            <?php } ?>
                      	  
							<a href='/myproxy_view.php?id=<?php echo $data['_id'] ?>'><?php echo $data['title'] ?></a>
							<div class='pull-right'><?php echo $GLOBALS['PROXY_TYPE'][$data['type']]['name'] ?></div>
							
                      </div>
                      </div>
                      <?php } ?>                                            
                  </div>
        </div>
        
    </div>

    </body>
</html>
