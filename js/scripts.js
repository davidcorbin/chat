var send = function(formEl) {
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

var get = function() {
    var chatpage = document.getElementById("newchat").value;
    $.ajax({
        url: "chatupdate",
        data: chatpage,
        type: "get",
        cache: "false",
        success: function(data) {
            if (data=="No") {
                $("#chattitle").text("Chat not found");
                $(".chat").html("<p>This chat doesn't exist. Would you like to create it?</p><button class='btn btn-default' onclick='createchat()'>Yes</button>");
            }
            else {
                $("#chattitle").text(chatpage);
                $(".chat").html(data); 
                document.getElementById("currentchat").value = chatpage;
            }
        }
    });
    return false;
}

function createchat() {
    var chatpage = $("#newchat").serializeArray();
    $.ajax({
        url: "chat",
        data: chatpage,
        type: "post",
        success: function(data) {
            //alert(data);
            get();
        }
    });
    return false;
}

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
		document.getElementsByClassName("upload")[0].innerHTML = "Upload";
		document.querySelector(".avatar").src = JSON.parse(xhr.responseText).upload.links.original;
	}
	xhr.send(fd);
}

function clickcall() {
    document.querySelector("#image").click();
}

function loadchat(el) {
    alert(el);
    return false;
}
