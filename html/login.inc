<?php

$form = '

<div class="row">
<!--
    <div class="col-md-6 col-lg-6">
        <div class="well">
            <h2></h2>
            <p>Now fully supporting mobile and tablet devices.</p>
            <a class="btn btn-primary btn-lg" href="adduser">Signup</a>
        </div>
    </div>
    //-->

    <div class="col-md-6 col-lg-6">
        <div class="jumbotron">
            <h1>Welcome to FRC Chat</h1>
            <p>Now fully supporting mobile and tablet devices.</p>
            <p><a class="btn btn-primary btn-lg" href="adduser">Signup</a></p>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="well">
            <form class="form-horizontal" method="post" action="login">
                <fieldset>
                    <legend>Login or <a href="adduser.php">Signup</a></legend>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Username</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="un">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="pw">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

';
