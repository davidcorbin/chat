<?php

echo '

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>FRC Chat</title>
<meta name="google-site-verification" content="jqrDMrsdhpyYvJW-39xEtOWIzArtUW8dnd7Lti5XPDY" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="stylesheet" href="css/bootstrap.css" media="screen">
<link rel="stylesheet" href="css/bootswatch.min.css">
<link rel="stylesheet" href="css/style.css">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script><script 
src="http://cdnjs.cloudflare.com/ajax/libs/fastclick/0.6.7/fastclick.min.js"></script>
<![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
';

echo isset($_SESSION["un"])?'
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
':"";

echo '
            <a href="chat.php" class="navbar-brand">FRC Chat <span style="color: red; font-size:small;">BETA</span></a>
        </div>
';

echo isset($_SESSION["un"])?'
        <div class="collapse navbar-collapse" id="navbar-toggle">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="chat">Chat</a></li>
                <li><a href="settings">Settings</a></li>
                <li><a href="login">Logout</a></li>
            </ul>
        </div>
':"";

echo '
    </div>
</nav>    

<style>
body {padding-top:70px;}
</style>

<div class="container" id="maincontainer">' . $content . '</div>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootswatch.js"></script>
' . "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60172009-1', 'auto');
  ga('send', 'pageview');

</script>
" . '
</body>
</html>
';
