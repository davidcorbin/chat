<?php

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
<p>By clicking creating an account you agree to the <a href="http://www.usfirst.org/aboutus/gracious-professionalism" target="_blank">Terms of Use</a>.</p>
                            <button type="submit" class="btn btn-primary">Create</button>       
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

';
