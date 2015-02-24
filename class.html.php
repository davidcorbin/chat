<?php

class html {
	// Default HTML template for content
	private function main($content) {
		echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>FRC Chat</title><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"><link rel="stylesheet" href="css/bootstrap.css" media="screen"><link rel="stylesheet" href="css/bootswatch.min.css"><!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --><!--[if lt IE 9]><script src="js/html5shiv.js"></script><script src="js/respond.min.js"></script><script src="http://cdnjs.cloudflare.com/ajax/libs/fastclick/0.6.7/fastclick.min.js"></script><![endif]--></head><body>
<div class="navbar navbar-default navbar-fixed-top"><div class="container"><div class="navbar-header"><a href="chat.php" class="navbar-brand">FRC Chat</a></div></div></div>
<style>body {padding-top:70px;}</style>
<div class="container" id="maincontainer">' . $content . '</div><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script><script src="js/bootstrap.min.js"></script><script src="js/bootswatch.js"></script></body></html>';
	}
	
	
	
	public function login($options) {
		$form = '<div class="row"><div class="col-lg-12"><div class="well"><form class="form-horizontal" method="post" action="login.php"><fieldset><legend>Login or <a href="adduser.php">Create Username</a></legend><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Username</label><div class="col-lg-10"> <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="un"></div></div><div class="form-group"><label for="inputPassword" class="col-lg-2 control-label">Password</label><div class="col-lg-10"><input type="password" class="form-control" id="inputPassword" placeholder="Password" name="pw"></div></div><div class="form-group"><div class="col-lg-10 col-lg-offset-2"><button type="submit" class="btn btn-primary">Submit</button></div></div></fieldset></form></div></div></div>';
		
		if ($options == 'incorrect') {
			$this->main($this->alertdanger('Incorrect username and/or password!') . $form);
		}
		
		elseif ($options == 'newuser') {
			$this->main($this->alertsuccess('User successfully created! Now login!') . $form);
		}
		
		else {
			$this->main($form);
		}
	}
	
	
	public function chat($info) {		
		$this->main($info);
	}
	
		
	public function adduser($error) {
		$form = '
	
	      <div class="row">
        <div class="col-lg-6">
          <div class="well">
            <form class="form-horizontal" method="post" action="adduser.php" autocomplete="off">
              <fieldset>
                <legend>Add User or <a href="login.php">Login</a></legend>
                <div class="form-group">
                  <label for="username" class="col-lg-2 control-label">Username</label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="Username" name="username" autocorrect="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="email" class="col-lg-2 control-label">Email</label>
                  <div class="col-lg-10">
                    <input type="email" class="form-control" placeholder="Email" name="email" autocorrect="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="username" class="col-lg-2 control-label">Password</label>
                  <div class="col-lg-10">
                    <input type="password" class="form-control" placeholder="Password" name="password" autocorrect="off">
                  </div>
                </div>
			    
                <div class="form-group">
                  <div class="col-lg-10 col-lg-offset-2">
By clicking creating an account you agree to the <a href="http://www.usfirst.org/aboutus/gracious-professionalism" target="_blank">Terms of Use</a>.<br>
                    <button type="submit" class="btn btn-primary">Create</button>       
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
	
      	';
		$this->main($error . $form);
	}
	
		public function settings($user) {
		$content = '
	
	      <div class="row">
        <div class="col-lg-6">
          <div class="well">
            <form class="form-horizontal" method="post" action="settings.php" autocomplete="off">
              <fieldset>
                <legend>Settings</legend>

                <div class="form-group">
                  <label for="upload" class="col-lg-2 control-label">Upload</label>
                  <div class="col-lg-10 col-lg-offset-2">
                    <img src="' . $user[0]['avatar'] . '">
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
		document.getElementsByClassName("upload")[0].innerHTML = "Done";
	}
	xhr.send(fd);
}

function clickcall() {
	document.querySelector("#image").click();
}
</script>
	
      	';
		$this->main($content);
	}

	public function alertdanger($content) {
		return '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
	
	public function alertsuccess($content) {
		return '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
}

