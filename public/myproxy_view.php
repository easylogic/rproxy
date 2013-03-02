<?php 
session_start();

$m = new Mongo("mongodb://youngman.kr");
$proxy = $m->rproxy->proxy;

$id = new MongoId($_GET['id']);

$find = array('_id' => $id);
$data = $proxy->findOne($find);

//var_dump($data);

$proxy_view = $m->rproxy->proxy_view;

$find = array(
    'title_id' => $id
);
//var_dump($find);
$list = $proxy_view->find($find)->sort(array(
	'before' => -1
));

//var_dump($list);

$color_list = array(
    'URL' => '',
    'DOM' => 'success',
    'REG' => 'error'
);
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
            
            
        }
    </script>
    <script>
        function popup(isUpdate, obj) {
            isUpdate = isUpdate || false; 
            
            $(".modal").data('isUpdate', isUpdate);
            
            if (!isUpdate) {
                $(".modal input[type=text]").val('');
                $(".modal textarea").val('');
                $(".modal .btn-group .active").removeClass('active');
                $(".modal .btn-group > button:first").addClass('active');
                
            } else {
                
            }
            
            $(".modal").modal();
            
        }
        
        function save() {
            var param = {
                title_id : "<?php echo $_GET['id']?>",
                type : $(".modal .btn-group > button.active").attr('data-value'),
                before : $(".modal #before").val(),
                after : $(".modal #after").val(),
                description : $(".modal #description").val()
            };
            
            $.post('/create_proxy.php', param, function(res) {
                if (res == 'ok') {
                    location.reload();
                }
            })
        }
        
        function delete_rule(id) {
        	var param = {
        		id : id 
        	};
        	
        	$.post('/delete_rule.php', param, function(res) {
        		if (res == 'ok') {
        			location.reload();
        		}
        	})
        }
        
        function share() {
            var param = {
                id : "<?php echo $_GET['id']?>",
            };
            
            $.post('/add_subscribe.php', param, function(res) {
                if (res == 'ok') {
                }
            })
        	
        }
        
        $(function() {
        	$(".tile").click(function(e) {
				$(".tile.selected").removeClass('selected');
        		$(e.currentTarget).addClass('selected');
        		
        		return false;
        	})
        })		
    </script>
    </head>
    <body>


    <?php include_once "header.php"; ?>        
    
    <div class='container'>
        <div class='page-header'>
            <h1><?php echo $data['title'] ?> <small>Proxy View</small></h1>
        </div>

            
        <?php if ($_SESSION['email'] == $data['email']) { ?> 
        <a href='#' class='btn' onclick="popup()">
        	<i class="icon-plus"></i> Add
        </a>
        <?php } else { ?> 
        <a href='#' class="btn" onclick="share()">
        	<i class='icon-share'></i> Subscribe
        </a>         
        <?php } ?>   

        
          <ul class='thumbnails' style='margin-top:10px;'>
              
          
          <?php foreach($list as $data) { ?> 
          <li class="span6">
              <div class=" alert alert-<?php echo $color_list[$data['type']] ?>">
                  <button type="button" onclick="delete_rule('<?php echo $data['_id'] ?>')" class="close" data-dismiss="alert">x</button>
                  <h6><span class='label label-info'><?php echo $data['type'] ?></span> <small><?php echo $data['description'] ?></small></h6>
                  <p><?php echo $data['before'] ?></p>
                  <p style='color:blue'><?php echo $data['after'] ?></p>
              </div>
          </li>
          <?php } ?>
          </ul>
          
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'rproxy'; // required: replace example with your forum shortname
    
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        
        
    </div>
    
    
            
    <div class="modal hide fade">
        <div class='modal-header'>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Create Rules</h3>
        </div>
        <div class='modal-body'> 
            <div class="input-control text">
                <div class="btn-group" data-toggle='buttons-radio' style='margin-bottom: 10px;'>
                    <button class="active btn btn-primary" data-value='URL' >URL</button>
                    <button class="btn btn-primary"  data-value="DOM">Domain</button>
                    <button class="btn btn-primary"  data-value="REG">Regular Expression</button>
                </div>
                
                <input type="text" placeholder="Before" id="before" class='input-block-level' />
                <input type="text" placeholder="After" id="after" class='input-block-level'/>
                <textarea id="description" placeholder="Description" class='input-block-level'></textarea>

            </div>                    
            
        </div>
        <div class='modal-footer'>
            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
            <a href="#" onclick='save()' class="btn btn-primary">Save changes</a>
        </div>

    </div>        

        
    </body>
</html>
