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
            if (data!="S") {
                $(".chat").html(data);
            }
        }
    });
    return false;
}

setInterval(function(){get();},2000);
window.onload = function(){get();}