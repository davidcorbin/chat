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


elseif (!empty($_GET)) {
	
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

	$chat = $database->fetch("SELECT * FROM `chat` ORDER BY date DESC LIMIT 50");
	$me = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");
	
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
        <div class="col-lg-12">
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
        	
            var send = function(formEl) {
            	if (document.getElementById("sendbutton").value == "") {
            		return false;
            	}

                var url = $(formEl).attr("action");

                var data = $("#sendbutton").serializeArray();

                $.ajax({
                    url: url,
                    data: data,
                    type: "post",
                    success: function() {
                        document.getElementById("sendbutton").value = "";
                    }
                });

                return false;
            }

            var get = function() {

                $.ajax({
                    url: "chat",
                    data: "Update",
                    type: "get",
                    cache: "false",
                    success: function(data) {
                        $(".chat").html(data);
                    }
                });

                return false;
            }

setInterval(function(){get();},2000);
window.onload = function(){get();}
        </script>
    
    <style>
.avatar {
    width:40px;
    height:40px;
}

    .chat 
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 60vh;
    -webkit-overflow-scrolling:touch;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}
    </style>'; 


$html->chat($info);
}
