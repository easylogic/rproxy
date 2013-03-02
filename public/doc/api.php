<?php
include_once "../lib.php";
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>RProxy to connecting server</title>
    <?php include_once "../resource.php" ?>
  </head>
  <body>
    <?php
    include_once "../header.php";
 ?>

    <div class='container'>
      <div class='page-header'>
        <h1>API</h1>
      </div>

      <div class='alert'>
        /api.php?cmd=data&email=cyberuls@gmail.com
      </div>
      <pre class='well'><?php include_once "api.json" ?></pre>      


    </div>
  </body>
</html>
