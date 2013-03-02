<?php 
session_start();

$m = new Mongo("mongodb://youngman.kr");
$bookmark = $m->rproxy->bookmark;
$proxy = $m->rproxy->proxy;

$cur = $bookmark->find(array('email' => $_SESSION['email']))->sort(array(
    '_id' => -1
));


$proxy_list = $proxy->find(array('email' => $_SESSION['email']))->sort(array(
    '_id' => -1
));


$type_list = array(
    'global' => 'success',
    'public' => 'info',
    'private' => 'error'
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
            } else if (type == 'global') {
                $('.title.public, .title.private').hide('fade');
                $('.title.global').show('fade');
            } else if (type == 'public') {
                $('.title.global, .title.private').hide('fade');
                $('.title.public').show('fade');
            } else if (type == 'private') {
                $('.title.public, .title.global').hide('fade');
                $('.title.private').show('fade');                                
            }
        }
        
        function proxy_view() {
            var values = [];
            $(".proxy_list :checked").each(function(i, elem){
                values.push(elem.value);
            })
            
            if (values.length == 0) {
                alert('Choose Proxy!');
                return false;
            }
            
            $.post('/preview.php', { values : values }, function(res){
                var $preview = $('.preview');
                $preview.empty();
                for(var k in res) {
                    var $li = $("<li class='nav-header' />").append(res[k].title);
                    $preview.append($li)
                    
                    var data = res[k].list;
                    
                    for(var i = 0, len = data.length; i < len; i++) {
                        var $li2 = $('<li />').append( data[i].type + " : " + data[i].before + " => " + data[i].after + " #" + data[i].description);                        
                        $preview.append($li2);
                    }
                    
                    $preview.append("<li class='divider'></li>");
                }
            });
        }
        
        function create() {
            var title = $('#title').val();
            var values = [];
            $(".proxy_list :checked").each(function(i, elem){
                values.push(elem.value);
            })
            
            $.post('/add_bookmark.php', { title : title, values : values}, function(res) {
                if (res == 'ok') {
                    location.reload();
                }
            })
            
        }
        
        $(function(){
            $(".bookmark-list a.bookmark-data").on('click', function(e) {
                $(".bookmark-list li.active").removeClass('active');
                var $a = $(e.currentTarget);
                $a.parent().addClass('active');
                var bookmark_id = $a.attr('data-id');
                
                $.post('/select_bookmark.php', { id : bookmark_id }, function(res) {
                    $('.proxy-data:checked').attr('checked', false);
                    for(var i in res.values) {                        
                        $(".proxy-data[data-value=" + res.values[i] + "]")[0].checked = true;
                    }
                    
                    proxy_view();
                })
            })
        })
        
	        
    </script>
    </head>
    <body>

    <?php include_once "header.php"; ?>

    <div class='container'>
        <div class='page-header'>
            <h1>
                Bookmark 
            </h1>
        </div>
        
        <div class='row'>
            <div class='span6'>
                <h2>Bookmark</h2>
                <ul class='nav nav-list bookmark-list well well-small' style='overflow:auto;height:140px;'>
                    <?php foreach ($cur as $data) {?>
                    <li><a href='#' class='bookmark-data' data-id="<?php echo $data['_id'] ?>"><?php echo $data['title'] ?></a></li>
                    <?php } ?>                  
                </ul>
            </div>
            <div class='span6'>
                <h2>Proxy</h2>
                <div class='nav nav-list proxy_list well well-small' style='overflow: auto; height:100px;'>
                    
                    <?php foreach($proxy_list as $proxy_data) {?>
                    <li>
                    <label class='checkbox'>
                        <input type='checkbox' class='proxy-data' value='<?php echo $proxy_data['_id'] ?>' data-value="<?php echo $proxy_data['_id'] ?>" onclick="proxy_view();"/>
                        <?php echo $proxy_data['title'] ?>    
                    </label>
                    </li>
                    <?php } ?>
                </div>
                <form class='form-inilne' style='margin: 10px 0 0'>
                    <div class="input-append">
                      <input class="span5" id="title" type="text">
                      <button class="btn" type="button" onclick="create()">Create</button>
                    </div>
                </form>                
            </div>
            <div class='span12'>
                <h2>Proxy View</h2>
                <ul class='preview nav nav-list well'>
                    
                </ul>
            </div>
        </div>
        
    </div>

    </body>
</html>
