/**
 * Created by davide on 10/01/17.
 */
$(document).ready(function () {
    /**
     * Notifications
     */
    $("#crea-notifica").on("click", function () {

        $.post("/core/gestisci_notifiche.php", {
            "id": "2",
            "title": $("#notif-title").val(),
            "desc": $("#notif-desc").val(),
            "sender": $("#notif-sender").val()
        }, function (data) {
            console.log(data);
            });
    });

    $("#crea-evento").on("click", function (e) {
       console.log($("#date").val());
       $.post("/core/events.php", {
                        "text":$("#text").val(),
                        "date":$("#date").val(),
                        "id": "24"}, function (e) {
           console.log(e);
           if(e == "OK"){
               console.log("OK!");
           } else {
               console.log("NOOO");
           }
       })
    });
});