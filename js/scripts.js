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
                $("#chattitle").text("#"+chatpage);
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

function changetheme(theme) {
    var theme_url;

    switch (theme) {
        case "Cerulean": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cerulean/bootstrap.min.css";
            break;
        case "Cosmo": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cosmo/bootstrap.min.css";
            break;
        case "Cyborg": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/cyborg/bootstrap.min.css";
            break;
        case "Darkly": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/darkly/bootstrap.min.css";
            break;
        case "Flatly": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css";
            break;
        case "Journal": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/journal/bootstrap.min.css";
            break;
        case "Lumen": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/lumen/bootstrap.min.css";
            break;
        case "Paper": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/paper/bootstrap.min.css";
            break;
        case "Readable": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/readable/bootstrap.min.css";
            break;
        case "Sandstone": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/sandstone/bootstrap.min.css";
            break;
        case "Simplex": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/simplex/bootstrap.min.css";
            break;
        case "Slate": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/slate/bootstrap.min.css";
            break;
        case "Spacelab": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/spacelab/bootstrap.min.css";
            break;
        case "Superhero": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/superhero/bootstrap.min.css";
            break;
        case "United": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/united/bootstrap.min.css";
            break;
        case "Yeti": 
            theme_url = "//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/yeti/bootstrap.min.css";
            break;
        default: 
            theme_url = "";
    }

    $("#theme").attr("href", theme_url);
}
