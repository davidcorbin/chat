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
                        <div class="col-lg-10">
                            <img src="' . $avatar . '" class="img-circle avatar">
                            <button type="button" class="btn btn-primary upload" onclick="clickcall(); return false;">Upload</button>
                        </div>
                        <input style="visibility: collapse; width: 0px; height: 0px;" type="file" onchange="upload(this.files[0])" id="image">
                        <input type="text" name="link" id="link" style="visibility: collapse; width: 0px; height: 0px;">
                    </div>

                    <div class="form-group">
                        <label for="teamnumber" class="col-lg-2 control-label">Team Number</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="teamnumber" name="teamnumber" ' . $teamnumber . '>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="teamposition" class="col-lg-2 control-label">Team Position</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="teamposition" name="teamposition" ' . $teamposition . '>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="userlocation" class="col-lg-2 control-label">Location</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="userlocation" name="userlocation" ' . $userlocation . '>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="website" class="col-lg-2 control-label">Site</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="website" name="website" ' . $userwebsite . '>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-2 control-label">Theme</label>
                        <div class="col-lg-10">
                            <select name="theme" class="form-control" onchange="changetheme(this.value)">
                                <option ' . ($theme=="default"?"selected='selected'":"") . '>Default</option>
                                <option ' . ($theme=="cerulean"?"selected='selected'":"") . '>Cerulean</option>
                                <option ' . ($theme=="cosmo"?"selected='selected'":"") . '>Cosmo</option>
                                <option ' . ($theme=="cyborg"?"selected='selected'":"") . '>Cyborg</option>
                                <option ' . ($theme=="darkly"?"selected='selected'":"") . '>Darkly</option>
                                <option ' . ($theme=="flatly"?"selected='selected'":"") . '>Flatly</option>
                                <option ' . ($theme=="journal"?"selected='selected'":"") . '>Journal</option>
                                <option ' . ($theme=="lumen"?"selected='selected'":"") . '>Lumen</option>
                                <option ' . ($theme=="paper"?"selected='selected'":"") . '>Paper</option>
                                <option ' . ($theme=="readable"?"selected='selected'":"") . '>Readable</option>
                                <option ' . ($theme=="sandstone"?"selected='selected'":"") . '>Sandstone</option>
                                <option ' . ($theme=="simplex"?"selected='selected'":"") . '>Simplex</option>
                                <option ' . ($theme=="slate"?"selected='selected'":"") . '>Slate</option>
                                <option ' . ($theme=="spacelab"?"selected='selected'":"") . '>Spacelab</option>
                                <option ' . ($theme=="superhero"?"selected='selected'":"") . '>Superhero</option>
                                <option ' . ($theme=="united"?"selected='selected'":"") . '>United</option>
                                <option ' . ($theme=="yeti"?"selected='selected'":"") . '>Yeti</option>
                            </select>
                        </div>
                    </div>

                
                    <div class="form-group">
                        <div class="col-lg-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="col-lg-10">
                            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteaccount">Delete Account</button>
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