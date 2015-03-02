var send = function(formEl) {
    if (document.getElementById("sendbutton").value == "") {
        return false;
    }

    var url = $(formEl).attr("action");
    var data = $("#sendbutton").serializeArray();

    $.ajax({
        url: url,
        data: data,
        type: "post",
        success: function() {
            document.getElementById("sendbutton").value = "";
        }
    });
    return false;
}

var get = function() {
    $.ajax({
        url: "chatupdate",
        data: "Update",
        type: "get",
        cache: "false",
        success: function(data) {
                $(".chat").html(data);
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
