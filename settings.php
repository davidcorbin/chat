<?php

require("config.php");

// Check for session vars but don't validate
if (!isset($_SESSION['un']) || !isset($_SESSION['pw'])) {
	header("Location: chat.php");
	die();
}

require_once('class.db.php');
$database = new db;

require_once('class.html.php');
$html = new html;

$user = $database->fetch("SELECT * FROM `logins` WHERE username='" . $_SESSION['un'] . "'");

if ( !empty($_POST) && $_POST['link']!="" ) {
	$database->query("UPDATE `logins` SET `avatar`='" .$_POST['link'] . "' WHERE username='" . $_SESSION['un'] . "'");
}

$content = '
	<div class="row">
        <div class="col-lg-6">
          <div class="well">
            <form class="form-horizontal" method="post" action="settings.php" autocomplete="off">
              <fieldset>
                <legend>Settings</legend>

                <div class="form-group">
                  <label for="upload" class="col-lg-2 control-label">Avatar</label>
                  <div class="col-lg-10 col-lg-offset-2">
                    <img src="' . $user[0]['avatar'] . '" class="img-circle avatar">
                    <button class="btn btn-primary upload" onclick="clickcall(); return false;">Upload</button>
<input style="visibility: collapse; width: 0px; height: 0px;" type="file" onchange="upload(this.files[0])" id="image">
<input type="text" name="link" id="link" style="visibility: collapse; width: 0px; height: 0px;">
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Save</button>       
                  </div>
                </div>

              </fieldset>
            </form>
          </div>
        </div>
      </div>

<style>
.avatar {
    width:40px;
    height:40px;
}
</style>

<script>
function upload(file) {
	if (!file || !file.type.match(/image.*/)) return;
	document.getElementsByClassName("upload")[0].innerHTML = "Uploading...";
	var fd = new FormData();
	fd.append("image", file);
	fd.append("key", "6528448c258cff474ca9701c5bab6927");
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "http://api.imgur.com/2/upload.json"); 
	xhr.onload = function() {
		document.querySelector("#link").value = JSON.parse(xhr.responseText).upload.links.original;
		document.getElementsByClassName("upload")[0].innerHTML = "Upload";
		document.querySelector(".avatar").src = JSON.parse(xhr.responseText).upload.links.original;
	}
	xhr.send(fd);
}

function clickcall() {
	document.querySelector("#image").click();
}
</script>
';

$html->settings($content);
