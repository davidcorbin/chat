<?php

$root = "/chat";

echo '

<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>First Connect | ' . $title . '</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="' . $theme_url . '" rel="stylesheet" id="theme">
<link rel="stylesheet" href="'.$root.'/css/style.css">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="'.$root.'/js/html5shiv.js"></script>
<script src="'.$root.'/js/respond.min.js"></script>
<![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
';

// If logged in, show navbar links
echo isset($_SESSION["un"])?'
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
':"";

echo '
            <a href="'.$root.'/chat" class="navbar-brand">First Connect <span style="font-size:small; color:red;">BETA</span></a>
        </div>
';

echo isset($_SESSION["un"])?'
        <div class="collapse navbar-collapse" id="navbar-toggle">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="'.$root.'/chat">Chat</a></li>
                <li><a href="'.$root.'/settings">Settings</a></li>
                <li><a href="'.$root.'/login">Logout</a></li>
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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="'.$root.'/js/bootswatch.js"></script>
<script src="'.$root.'/js/scripts.js"></script>
' . "
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60172009-1', 'auto');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>
" . '
</body>
</html>
';
