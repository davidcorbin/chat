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

// Update chat window content
elseif (!empty($_GET) && isset($_GET['Update'])) {

	// Function for converting chat message time to "minutes ago"
	function timeconvert($ptime) {
		$etime = time() - $ptime;
		if ($etime < 1) {
			return '0 seconds';
		}
		$a = array(12 * 30 * 24 * 60 * 60  =>  'year',
				30 * 24 * 60 * 60       =>  'month',
				24 * 60 * 60            =>  'day',
				60 * 60                 =>  'hour',
				60                      =>  'minute',
				1                       =>  'second'
		);

		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
			}
		}
	}

	// Fetch database values for latest comments and user data
	$chat = $database->fetch("SELECT * FROM `chat` ORDER BY date DESC LIMIT 50");
	$me = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	
	/*
	// If no new posts
	if (isset($_SESSION['latest_update']) && $_SESSION['latest_update']==$chat[0]["id"]) {
		echo "S";
		exit();
	}
	*/
	
	// Set session var for latest update from client
	$_SESSION['latest_update'] = $chat[0]["id"];
	
	for ($i = 0; $i < count($chat); $i++) {
		// If post is my me
		if ($chat[$i]['user'] == $_SESSION['un']) {
		
			if ($me[0]['avatar']=="") {
				$avatar = "http://placehold.it/50/FA6F57/fff&text=ME";
			}
			else {
				$avatar = $me[0]['avatar'];
			}
			echo '<li class="right clearfix"><span class="chat-img pull-right"><a href="profile?' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">';
			
			// If admin, show icon in front of name
			echo $me[0]['type']=="admin"?'<span class="glyphicon glyphicon-flash" style="color:black;"></span>':'';
			echo $chat[$i]['user'];
			echo '</strong><small class="pull-right text-muted"> <span class="glyphicon glyphicon-time"></span>';
			echo timeconvert($chat[$i]['date']);
			echo '</small></div><p>';
			echo htmlspecialchars($chat[$i]['data']);
			echo '</p></div></li>';
		}
		
		// If post is by anyone else
		else {
		
			$chat_user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $chat[$i]['user'] . "'");
		
			if (empty($chat_user) || $chat_user[0]['avatar']=="") {
				$avatar = "http://placehold.it/50/55C1E7/fff&text=U";
			}
			else {
				$avatar = $chat_user[0]['avatar'];
			}
			
			echo '<li class="left clearfix"><span class="chat-img pull-left"><a href="profile?' . $chat[$i]['user'] . '"><img src="' . $avatar . '" alt="User Avatar" class="img-circle avatar" /></a></span><div class="chat-body clearfix"><div class="header"><small class=" text-muted"><span class="glyphicon glyphicon-time"></span>';
			echo timeconvert($chat[$i]['date']);
			echo '</small><strong class="pull-right primary-font">';
			
			// If admin show icon in front of name
			echo !empty($chat_user) && $chat_user[0]['type']=="admin"?'<span class="glyphicon glyphicon-flash" style="color:black;"></span>':'';
			echo $chat[$i]['user'];
			echo '</strong></div><p>';
			echo htmlspecialchars($chat[$i]['data']);
			echo '</p></div></li>';
		}		
	}
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
