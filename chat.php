<?php

require("config.php");

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

//Check for session vars
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	header("Location: login.php");
	die();
}

//Authorize session credentials
$check = $database->auth($_SESSION["un"], $_SESSION["pw"]);
if (!isset($check)) {
	header("Location: login.php");
	die();
}

// New chat message sent
if (!empty($_POST) && isset($_POST['sendbutton'])) {
	$database->query("INSERT INTO `chat`(`data`, `user`, `date`) VALUES ('" . $database->escape($_POST['sendbutton']) . "','" . $_SESSION['un'] . "','" . time() . "')");
}


else {

$info = '
   <div class="row">
        <div class="col-md-8 col-lg-6 col-centered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span>
                </div>
                <div class="panel-body">
                    <ul class="chat">





                    </ul>
                </div>
                <div class="panel-footer">
<form method="post" action="chat" onsubmit="return send(this);">
                    <div class="input-group">
                        <input name="sendbutton" id="sendbutton" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
</form>
                </div>
            </div>
        </div>
    </div>

        <script type="text/javascript">

        </script>
    
'; 


	$html->chat($info);
}
