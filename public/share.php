<?php 
session_start();

$m = new Mongo("mongodb://youngman.kr");
$friends = $m->rproxy->friends;

$email = $_SESSION['email'];

$cur = $friends->find(array('email' => $email))->sort(array(
	'friend' => 1
));

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>RProxy to connecting server</title>
	<?php include_once "resource.php" ?>
    <script type="text/javascript">
        
        function share() {
        	
        }
        
        function select_all() {
        	$(".tile").toggleClass("selected");
        }
        
        $(function() {
        	$(".tile").click(function(e) {
        		$(e.currentTarget).toggleClass('selected');
        		
        		return false;
        	})
        })	        
    </script>
	<style>
		.tile {
			height: 75px;
		}
	</style>
    </head>
    <body>

    <?php include_once "header.php"; ?>

    <div class='page secondary'>
        <div class='page-header'>
            <div class='page-header-content'>
                <h1>Share <i class='icon-share'></i></h1>
                <a href="/myproxy.php" class="back-button big page-back"></a>
            </div>
        </div>
        <div class='page-region'>
            <div class='page-region-content'>

			  <h2>Message</h2>
			  <form>
			  	<input type='hidden' id='' value='' />
			  	<input type='hidden' id='' value='' />
			  	<input type='hidden' id='' value='' />
			  	<input type='hidden' id='' value='' />
				<div class="input-control text">
					<input type='text' readonly="readonly" value='' />
				</div>
			  	<div class="input-control textarea">
			        <textarea placeholder='message'></textarea>
			    </div>
			    <div>
			    	<button class='big' type='button' onclick="select_all()"><i class='icon-user icon-large'></i> Select All</button>
			    	<button class='big' type='button' ><i class='icon-share icon-large'></i> Share</button>
			    </div>
			  </form>
              <h2>Friends</h2>
              <div class='clearfix'>
                 <?php foreach($cur as $data) { ?>
                 <div class='tile double'>
                 	<div class='tile-content'>
                 		<h3><?php echo $data['friend'] ?></h3>
                 	</div>
                 	
                 </div>
                 <?php } ?> 
              </div>
                            
            </div>
          
           
        </div>
        
    </div>
    </body>
</html>
