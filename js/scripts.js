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
