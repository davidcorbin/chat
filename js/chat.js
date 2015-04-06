setInterval(function(){get();},3000);

window.onload = function(){
    $("#profileView").on("show.bs.modal",function (event) { loadProfile(event); });
    $(window).on("hashchange", function() {
        document.getElementById("newchat").value = window.location.hash.substring(1);
        get();
    });

    initChatInput();
    get();
}