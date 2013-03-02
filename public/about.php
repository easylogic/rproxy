<?php 
session_start();


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
            <h1>About</h1>
        </div>
        <div>
            <div class='page-header'>
                <h2>What is RProxy?</h2>
            </div>
            <p>
                RProxy 는 자신이 가지고 있는 사이트 목록을 공유하는 사이트입니다. 
                <br />
                <br />
                http proxy 를 통해서 특정 주소가 내가 원하는 사이트로 갈 수 있도록 해주는 reverse proxy 에 대한 규칙을 설정하고 공유합니다. 
            </p>
            <div class='page-header'>
                <h2>What is API?</h2>
            </div>
            <p>
                RProxy 는 리스트에 대한 API 를 제공합니다.
                <br /> 
                <br /> 
                사이트에 대한 목록을 원하는 포맷으로 다운받을 수 있습니다. 
            </p>
            <div class='page-header'>
                <h2>What is Client?</h2>
            </div>
            <p>
                RProxy 의 API를 이용할 수 있는 Client(Http Proxy 서버) 를 제공합니다.
                <br /> 
                <br /> 
                
                제공 예정
                <br />
                <br />

                <ul>
                    <li>Fiddler AddOn</li>
                    <li>Fiddler Core Application</li>
                    <li>Nodejs Http Proxy Server</li>
                </ul>                           
            </p>
        </div>
	</div>
    </body>
</html>
