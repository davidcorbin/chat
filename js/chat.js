window.onload = function(){
    $("#profileView").on("show.bs.modal",function (event) { 
        loadProfile(event); 
    });

    $(window).on("hashchange", function() {
        document.getElementById("newchat").value = window.location.hash.substring(1);
        get();
    });

    initChatInput();
    get();
}

// Update chat forever
setInterval(function(){get();},3000);

// Global number of posts in chat
var numofposts = 0;

// Database id of latest post
var latestpost = -1;

// Previous get() chat name
var prevchatname = "";

// Function for sending a chat message
function send(formEl) {
    if (document.getElementById("sendbutton").value == "") {
        return false;
    }

    var url = $(formEl).attr("action");
    var data = $("#chatmes").serializeArray();

    $.ajax({
        url: url,
        data: data,
        type: "post",
        success: function(data) {
            document.getElementById("sendbutton").value = "";
            get();
        }
    });
    return false;
}

// Function for getting chat json from database
function get() {
    var chatpage = document.getElementById("newchat").value;

    // Update URL hash
    window.location.replace(window.location.href.split('#')[0] + '#' + chatpage);

    // If previous chat name hasn't been set (get hasn't been called)
    if (prevchatname == "") {
        prevchatname = chatpage;
    }
    // User changed chat; clear chat box and reset post count
    else if (prevchatname != chatpage) {
        $(".chat").html("");
        latestpost = -1;
        numofposts = 0;
        prevchatname = chatpage;
    }

    $.ajax({
        url: "chatupdate",
        data: { "chatpage": chatpage, "latestpost": latestpost },
        type: "get",
        cache: "false",
        success: function(data) {

            // If chat doesn't exist and can be created
            if (data=="create") {
                $("#chattitle").text("Chat not found");
                $(".chat").html("<p>This chat doesn't exist. Would you like to create it?</p><button class='btn btn-default' onclick='createchat()'>Yes</button>");
            }

            // If chat can't be created for whatever reason
            else if (data=="no") {
                $("#chattitle").text("Chat can't be created");
                $(".chat").html("<p>This chat can't be created.</p>");
            }

            // Continue to parse json
            else {
                // Change chat title
                $("#chattitle").text("#"+chatpage);

                var resultjson = JSON.parse(data);

                // Loop through all returned posts
                for (var i = 0; i < resultjson.length; i++) {

                    // If post is from me
                    if (resultjson[i].me == true) {

                        $("<li></li>", {
                            "class": "right clearfix " + numofposts
                        }).prependTo(".chat");

                        $("<span></span>", {
                            "class": "chat-img pull-right"
                        }).appendTo("." + numofposts.toString());

                    }
                    // Post is from someone other than me
                    else {

                        $("<li></li>", {
                            "class": "left clearfix " + numofposts
                        }).prependTo(".chat");

                        $("<span></span>", {
                            "class": "chat-img pull-left"
                        }).appendTo("." + numofposts.toString());

                    }

                    $("<a></a>", {
                        'data-toggle':"modal",
                        'data-target':"#profileView",
                        'data-user':resultjson[i].user
                    }).appendTo("." + numofposts.toString() + " span");

                    $("<img />", {
                        'src':resultjson[i].avatar,
                        "alt":"Profile Image",
                        "class":"img-circle avatar"
                    }).appendTo("." + numofposts.toString() + " span a");

                    $("<div class='chat-body clearfix'><div class='header'>").appendTo("." + numofposts.toString());

                    $("<strong>" + resultjson[i].user + "</strong>", {
                        "class":'primary-font'
                    }).appendTo("." + numofposts.toString() + " div.chat-body div.header");

                    $('<small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>' + resultjson[i].date + '</small></div>').appendTo("." + numofposts.toString() + " div.chat-body div.header");

                    $('<p>' + resultjson[i].data + '</p></div></li>').appendTo("." + numofposts.toString() + " div.chat-body div.header");


                    if (parseInt(resultjson[i].id) > latestpost) {
                        latestpost = parseInt(resultjson[i].id);
                    }

                    numofposts++;
                }
                document.getElementById("currentchat").value = chatpage;
            }
        }
    });
    return false;
}

// Function for creating chat if it doesn't exist
function createchat() {
    var chatpage = $("#newchat").serializeArray();
    $.ajax({
        url: "chat",
        data: chatpage,
        type: "post",
        success: function(data) {
            if (data == "1") {
                chat_create_error("No chat name given");
            }
            if (data == "created") {
                chat_create_success();
            }

            get();
        }
    });
    return false;
}

function chat_create_error(error) {
    $("#newchatfeedback").removeClass("has-success");
    $("#newchatfeedback").removeClass("has-success");
    $("#newchatfeedback").addClass("has-error");
    $("#chatfeedback").html(error);
}

function chat_create_success() {
    $("#newchatfeedback").removeClass("has-success");
    $("#newchatfeedback").removeClass("has-error");
    $("#newchatfeedback").addClass("has-success");
}

function chat_create_default() {
    $("#newchatfeedback").removeClass("has-success");
    $("#newchatfeedback").removeClass("has-success");
    $("#newchatfeedback").removeClass("has-error");
}

function loadProfile(event) {
    var button = $(event.relatedTarget);
    var recipient = button.data("user");
    var modal = $(".modal");

    $.get( "profile/"+recipient, function( data ) {
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

// Called at page load to get the page hash and make it the current chat
function initChatInput() {
    if (window.location.hash) {
        document.getElementById("newchat").value = window.location.hash.substring(1);
    } 
}
