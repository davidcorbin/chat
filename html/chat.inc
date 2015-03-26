<?php

$info = '
<div class="row">
    <div class="col-md-8 col-lg-6 col-centered">
        <div class="panel panel-primary">
            <div class="panel-heading">
               <!-- <span>' . $page . '</span>//-->  <span id="chattitle" style="display:inline-block;"></span>
            </div>
            <div class="panel-body">
                <ul class="chat">
                </ul>
            </div>
            <div class="panel-footer">
                <form id="chatmes" name="chatmes" method="post" action="chat" onsubmit="return send(this);">
                    <input type="hidden" name="currentchat" id="currentchat" value="">
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


    <div class="col-md-8 col-lg-6 col-centered">
        <div class="list-group">
            <a class="list-group-item active">Create or switch to:</a>
            <div class="list-group-item">


   <form role="form" onsubmit="return loadchat(this)">
      <div class="row">
         <div class="col-lg-6">
<div id="newchatfeedback" class="form-group has-feedback">
<label class="control-label" id="chatfeedback"></label>
            <div class="input-group">
               <input type="text" value="chat" id="newchat"  name="newchat" class="form-control" onkeypress="get()" onchange="get()" oninput="get()">
               <span class="input-group-addon" onclick="document.getElementById(\'newchat\').submit()">
                  Go
               </span>
            </div>
</div>
         </div>
      </div>
   </form>

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

<style>
.modal-body p {
    text-align:center;
}
</style>

<script type="text/javascript">
setInterval(function(){get();},3000);

window.onload = function(){
  $("#profileView").on("show.bs.modal", function (event) {
    loadProfile(event);
  });
  get();
}

function loadProfile(event) {
    var button = $(event.relatedTarget);
    var recipient = button.data("user");
    var modal = $(".modal");

    $.get( "profile/"+recipient, function( data ) {
//alert(data);
        var p = document.querySelectorAll(".modal-body p"), i;
        for (i = 0; i < p.length; ++i) {
            p[i].style.display = "block";
        }
        var profile = JSON.parse(data);
        document.querySelector("#profileav").src = profile.avat;
        if (profile.team == "0") {
            document.querySelector("#profileteamwrap").style.display = "none";    
        }
        if (profile.pos == "") {
            document.querySelector("#profileposwrap").style.display = "none";    
        }
        if (profile.loc == "") {
            document.querySelector("#profilelocwrap").style.display = "none";    
        }
        if (profile.site == "") {
            document.querySelector("#profilesitewrap").style.display = "none";    
        }
        document.querySelector("#profileteam").textContent = profile.team;
        document.querySelector("#profilepos").textContent = profile.pos;
        document.querySelector("#profileloc").textContent = profile.loc;
        document.querySelector("#profilesite").textContent = profile.site;
        document.querySelector("#profilesite").href = profile.site;
        document.querySelector("#profilecreatedat").textContent = profile.createat;
        document.querySelector("#profileviews").textContent = profile.views;
        document.querySelector("#profileposts").textContent = profile.posts;


    });

    modal.find(".modal-title").text(recipient);
}
</script>
    
'; 
