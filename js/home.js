/**
 * Created by CarloAlberto on 22/12/16.
 */


/**
 * .ready executes when html DOM has been parsed
 */
$(document).ready(function () {

    /**
     * Load calendar & home page
     */
    $("#cal-content").load("/pages/calendar.html");




    /**
     * Gestione sidebar and toggling
     */
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = true;

    trigger.click(function () {
        hamburger_cross();
    });

    $(window).resize(function(){
        if ($(window).width() <= 766){
            //console.log("FIRE!");
            if(isClosed){
                hamburger_cross();
                $("#wrapper").removeClass("toggled");
            }
        } else if ($(window).width() >= 1200){
            if(!isClosed){
                hamburger_cross();
                $("#wrapper").addClass("toggled");
            }
        }
    });

    /**
     * Hamburger close/open
     */
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
     * dropdown click event on notifications button (CHANGE ID)
     */
    $(".menu-parent").on("shown.bs.dropdown", function (event) {
        //importa tutte le notifiche "viste"
        console.log("notifiche viste");

        $.post("/core/gestisci_notifiche.php", {"id":"2"});
    });

    /**
     * retrieve notifications (CHANGE ID)
     */
    function checkNotifications() {
        $.get("/core/gestisci_notifiche.php", {"id": "2"}, function (data) {
            //console.log(data);
            var c = JSON.parse(data);

            if(c.total > 0) {
                $("#total_not").text(c.total);
            } else {
                $("#total_not").text("");
            }
            //Remove all old notifications
            $(".message-preview").each(function (index) {
                if(index>0)
                    $(this).remove();
            });

            //c data index
            //0->title
            //1->desc
            //2->date
            //3->showed
            //4->n click
            //5->id-notifica
            for(var n = 0 ; n < 6; n++){
                $template = $("#not-template").clone().attr('id',c[n][5]).removeAttr('hidden').show();
                $("#not-title", $template).text(c[n][0]);
                $("#not-date", $template).text(c[n][2]);
                $("#not-body",$template).text(c[n][1]);
                if(c[n][4] == 0)
                    $template.addClass('notification-not-viewed');
                $template.bind("click", function (e) {
                    //notifica cliccata, invia +1 al server

                    $.post("/core/gestisci_notifiche.php", {"id-notifica":$(this).attr('id')}, function (data) {
                        $(this).removeClass("notification-not-viewed");
                        console.log(data);
                    });

                    //inserisci location
                    e.preventDefault();
                });

                $template.insertBefore("#view-all");
            }

        });
    }

    checkNotifications();

    setInterval(function () {
        //console.log("cerco notifiche..");
        checkNotifications();
    }, 2000);


});

/**
 * .on("load") executes when all the page (img included) is loaded.
 */
$(window).on("load", function() {

    /**
     * Loading Footer
     */
    $("#footer-content").load("footer.html");


    // Animate loader off screen
    $(".se-pre-con").delay(700).fadeOut("slow");

});

$("#tab_notifications").on('click', function () {
    $("#main-content").load("/pages/notifications.html");
});


/**
 * Function for fixing on top the navbars while scrolling down.
 */
$(document).on("scroll", function (height) {
    var h = $(document).scrollTop();
    var fixed_height = 81;

    if(h >= fixed_height) {
        $("#nav-options").css("top", "0");
        $(".navbar-fixed-top").css({"top":"0"});
    } else {
        $("#nav-options").css("top",fixed_height-h);
        $(".navbar-fixed-top").css({"top": fixed_height-h});
    }
});