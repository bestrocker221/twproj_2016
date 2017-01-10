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
            "title": "Nuovo allenamento!",
            "desc": "giovedi alle 15"
        }, function (data) {
            //console.log("OK? " + data);
        });
        //console.log("cerco notifiche..");

    });
});