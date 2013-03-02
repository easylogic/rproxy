

<div class="navbar navbar-inverse navbar-fixed-top">

  <div class='navbar-inner'>

    <div class='container'>        
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>        
        <a class='brand' href='/'>RProxy</a>
        <div class="nav-collapse collapse">
        <ul class='nav'>
            <?php if ($_SESSION['email']) { ?>
            <li class='dropdown active'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'><?php echo $_SESSION['email'] ?><b class='caret'></b></a>
                <ul class='dropdown-menu'>
                    <li><a href='/myproxy.php' >My Proxy</a></li>
                    <li><a href='/bookmark.php' >My Bookmark</a></li>
                    <li><a href='/friends.php'>Friends</a></li>
                    <li class='divider'></li>
                    <li><a href='/logout.php'>Logout</a></li>
                    
                </ul>   
            </li> 
            <?php } else if ($_SESSION['oauth']) { ?>
            <li class='dropdown active'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'><?php echo $_SESSION['name'] ?> <span class='label'> <?php echo $_SESSION['oauth'] ?></span><b class='caret'></b></a>
                <ul class='dropdown-menu'>
                    <li><a href='/myproxy.php' >My Proxy</a></li>
                    <li><a href='/bookmark.php' >My Bookmark</a></li>
                    <li><a href='/friends.php'>Friends</a></li>
                    <li class='divider'></li>
                    <li><a href='/logout.php'>Logout</a></li>
                    
                </ul>   
            </li>             
            <?php } else { ?>
            <li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' >Sign <b class='caret'></b></a>
                <ul class='dropdown-menu'>
                    <li><a href='/auth/twitter/oauth.php'>Twitter</a></li>
                    <li><a href='/auth/facebook/oauth.php'>Facebook</a></li>
                    <li><a href='/auth/tumblr/oauth.php'>Tumblr</a></li>
                    <li class='divider'></li>
                    <li><a href='/login.php'>Local</a></li>
                </ul>
            </li>
            <?php } ?>
            <li class='dropdown'>
                <a href="#" class='dropdown-toggle' data-toggle='dropdown'>Document<b class="caret"></b></a>
                <ul class='dropdown-menu'>
                    <li><a href='/doc/api.php' >API</a></li>
                </ul>
            </li>
            <li><a href="/about.php">About</a></li>
            <li><a href="/contact.php">Contact</a></li>
        </ul>
        </div>
    </div>
  </div>
</div>
