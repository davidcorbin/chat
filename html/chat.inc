<?php

$info = '
<div class="container">

    <div class="col-md-4 col-lg-4">

' . $myprofile . '

        <div class="col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <form role="form" onsubmit="return loadchat(this)">
                        <div class="input-group">
                            <input type="text" value="chat" id="newchat"  name="newchat" class="form-control" onkeypress="get()" onchange="get()" oninput="get()">
                            <span class="input-group-addon" onclick="document.getElementById(\'newchat\').submit()">Go</span>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                ' . $trends . '
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-8 col-lg-8">

        <div class="col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   <span id="chattitle" style="display:inline-block;">Loading...</span>
                </div>
                <div class="panel-body chat-window">
                    <ul class="chat"></ul>
                </div>
                <div class="panel-footer">
                    <form id="chatmes" name="chatmes" onsubmit="return send(this);">
                        <div class="input-group">
                            <input name="sendbutton" id="sendbutton" type="text" class="form-control input-sm" autocomplete="off" placeholder="Type your message here..." />
                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-sm" id="btn-chat">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>




<div class="modal fade" id="profileView" tabindex="-1" role="dialog" aria-labelledby="profileName" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="profileName">Username</h4>
      </div>
      <div class="modal-body">
        <img id="profileav" class="avatar-lg img-circle" src="" style="margin:auto; display:block;">
        <hr>
        <p id="profileteamwrap">Team: <span id="profileteam"></span></p>
        <p id="profileposwrap">Position: <span id="profilepos"></span></p>
        <p id="profilelocwrap">Location: <span id="profileloc"></span></p>
        <p id="profilesitewrap">Site: <a target="_blank" id="profilesite" href=""></a></p>
        <p>Created: <span id="profilecreatedat"></span></p>
        <p>Profile Views: <span id="profileviews"></span></p>
        <p>Posts: <span id="profileposts"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="js/chat.js"></script>
    
'; 
