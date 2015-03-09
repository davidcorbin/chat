<?php

$info = '
<div class="row">
    <div class="col-md-8 col-lg-6 col-centered">
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


    <div class="col-md-8 col-lg-6 col-centered">
        <div class="list-group">
            <a class="list-group-item active">Create or switch to:</a>
            <div class="list-group-item">
                <div class="input-group">
                    <form>
                        <input name="newchat" type="text" class="form-control input-sm" placeholder="DriverStation" id="newchat" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-sm" style="display:inline-block;">Go</button>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
setInterval(function(){get();},3000);
window.onload = function(){get();}
</script>
    
'; 