<?php

class html {
	// Default HTML template for content
	private function main($content) {
		echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>FRC Chat</title><meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"><link rel="stylesheet" href="css/bootstrap.css" media="screen"><link rel="stylesheet" href="css/bootswatch.min.css"><!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --><!--[if lt IE 9]><script src="js/html5shiv.js"></script><script src="js/respond.min.js"></script><script src="http://cdnjs.cloudflare.com/ajax/libs/fastclick/0.6.7/fastclick.min.js"></script><![endif]--></head><body>
<div class="navbar navbar-default navbar-fixed-top"><div class="container"><div class="navbar-header"><a href="chat.php" class="navbar-brand">FRC Chat <span style="color: red; font-size:small;">BETA</span></a></div></div></div>
<style>body {padding-top:70px;}</style>
<div class="container" id="maincontainer">' . $content . '</div><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script><script src="js/bootstrap.min.js"></script><script src="js/bootswatch.js"></script></body></html>';
	}
	
	
	
	public function login($options) {
		$form = '<div class="row"><div class="col-lg-12"><div class="well"><form class="form-horizontal" method="post" action="login"><fieldset><legend>Login or <a href="adduser.php">Create Username</a></legend><div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Username</label><div class="col-lg-10"> <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="un"></div></div><div class="form-group"><label for="inputPassword" class="col-lg-2 control-label">Password</label><div class="col-lg-10"><input type="password" class="form-control" id="inputPassword" placeholder="Password" name="pw"></div></div><div class="form-group"><div class="col-lg-10 col-lg-offset-2"><button type="submit" class="btn btn-primary">Submit</button></div></div></fieldset></form></div></div></div>';
		
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
            <form class="form-horizontal" method="post" action="adduser" autocomplete="off">
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
	
		public function settings($content) {
		$this->main($content);
	}

	public function alertdanger($content) {
		return '<div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
	
	public function alertsuccess($content) {
		return '<div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">×</button>' . $content . '</div>';
	}
}

