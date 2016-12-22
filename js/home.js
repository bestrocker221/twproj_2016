/**
 * Created by bsod on 22/12/16.
 */
$(document).ready(function () {

    /**
     * Gestione sidebar and toggling
     */
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = true;

    trigger.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed == true) {
            //overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {
            //overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
    });


    /**
     * Notifications
     */
    $("#crea-notifica").on("click",function () {
        $.post("/core/gestisci_notifiche.php", {"id" : "2","title":"Nuovo allenamento!" ,"desc":"giovedi alle 15"},function (data) {
            console.log("OK? " + data);
        });
        console.log("cerco notifiche..");
    });

    /**
     * dropdown click event on notifications button
     */
    $(".menu-parent").on("shown.bs.dropdown", function (event) {
        //importa tutte le notifiche "viste"
        //se è stata generata prima di 2s fa allora fai alert altrimenti lasciale nella lista senza alert
        console.log("notifiche viste");

        //$.post("/core/gestisci_notifiche.php", {"id":"2"});
    });

    function checkNotifications() {
        $.get("/core/gestisci_notifiche.php", {"id": "2"}, function (data) {
            //console.log(data);
            var c = JSON.parse(data);
            console.log(c);
            $("#total_not").text(c.total);

            //Remove all old notifications
            $(".message-preview").each(function () {
                $(this).remove();
            });
            //set the new ones
            for(var n = 0 ; n < 6; n++){
                var k = document.createElement("li");
                k.innerHTML = "<a href=\""+ n +"\">"+ c[n][0]+"->"+c[n][1]+ " date: " +c[n][2]+"</a>";
                //k.innerHTML = '<a href="">ciao' + n + '</a>';
                $(k).addClass("message-preview");
                $("#notification-separator").before(k);
            }

        });
    }
/*
    checkNotifications();

    setInterval(function () {
        console.log("cerco notifiche..");
        checkNotifications();
    }, 2000);
*/
});

/**
 * Function for fixing on top the navbars while scrolling down.
 */
$(document).on("scroll", function (height) {
    var h = $(document).scrollTop();
    var fixed_height = 81;
    //console.log("dal top ci sono: " + h);
    if(h >= fixed_height) {
        $("#nav-options").css("top", "0");
        $(".navbar-fixed-top").css({"top":"0"});
    } else {
        $("#nav-options").css("top",fixed_height-h);
        $(".navbar-fixed-top").css({"top": fixed_height-h});
    }
    //console.log(height);
});