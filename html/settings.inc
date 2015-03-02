<?php

$content .= '

<div class="row">
    <div class="col-lg-6">
        <div class="well">
            <form class="form-horizontal" method="post" action="settings" autocomplete="off">
                <fieldset>
                    <legend>Settings</legend>

                    <div class="form-group">
                        <label for="upload" class="col-lg-2 control-label">Avatar</label>
                        <div class="col-lg-10 col-lg-offset-2">
                            <img src="' . $avatar . '" class="img-circle avatar">
                            <button class="btn btn-primary upload" onclick="clickcall(); return false;">Upload</button>
                            <input style="visibility: collapse; width: 0px; height: 0px;" type="file" onchange="upload(this.files[0])" id="image">
                            <input type="text" name="link" id="link" style="visibility: collapse; width: 0px; height: 0px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">Username</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="un">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteaccount">Delete Account</button>       
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




<div class="modal fade" id="deleteaccount" tabindex="-1" role="dialog" aria-labelledby="deleteaccountlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteaccountlabel">Delete account</h4>
            </div>
            <div class="modal-body">
Are you sure you wish to delete your account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-danger" href="settings?delete">Delete account</a>
            </div>
        </div>
    </div>
</div>

';