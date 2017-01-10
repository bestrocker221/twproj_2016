/**
 * .ready executes when html DOM has been parsed
 */
$(document).ready(function () {


    /**
     * Load unibo home
     */
    function loadHome() {
        $("#main-content").load("/pages/home-unibo.html", function (e) {
            /**
             * Load calendar & home page
             */
            $("#cal-content").load("/pages/calendar.html");

            /**
             * Carico news
             */

            $.get("/core/news-manager.php", function (data) {
                var c = JSON.parse(data);

                //legend
                //c[0] id
                //c[1] text
                //c[2] date
                for(var n=0; n< c.length; n++) {
                    $template = $("#news-li-template").clone().attr('id', c[n]["id"]).removeClass('no-active').show();
                    $("#id", $template).text(c[n]["id"]);
                    $("#news-li-p", $template).text(c[n]["text"]);
                    $("#news-li-data", $template).text(c[n]["date"]);

                    //bind? TODO?


                    $template.insertAfter("#news-li-template");
                }

                $("#news-li-template").remove();

                $("#news-ul").bootstrapNews({
                    newsPerPage: 3,
                    autoplay: true,

                    onToDo: function () {
                        //console.log(this);
                    }
                });
            });
        });
    }

    loadHome();


    $("#home-btn").bind('click', function (e) {
       loadHome();
       e.preventDefault();
        removeAllBreadcrubsAfter("Home");
    });

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
     * dropdown click event on notifications button (CHANGE ID)
     */
    $(".menu-parent").on("shown.bs.dropdown", function (event) {
        //importa tutte le notifiche "viste"
        console.log("notifiche viste");

        $.post("/core/gestisci_notifiche.php", {"id":"2"});
    });

    /**
     * Load moadal
     */
    $(document.body).append("<div id='result-modal'></div>");
    $("#result-modal").load("modal.html");

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

                        $(".modal-title").html($(this).find("strong").text());
                        $(".modal-body").html($(this).find("p:odd").text());
                        $("#myModal").modal('show');
                    });

                $template.insertBefore("#view-all");
            }

        });
    }



    loadProfileInfo();
    checkNotifications();

    setInterval(function () {
        //console.log("cerco notifiche..");
        checkNotifications();
    }, 2000);

});

/**
 * Get user Information.
 */
function loadProfileInfo(){
    $.get("core/info.php", function (e) {
        console.log(e);

        var data = JSON.parse(e);

        console.log(data);

        $("#name").text(data.surname + " " +data.name);
        $("#member-email").text(data.username);
        $("#member-name").text(data.name);

        //$("#school");
        //$("#department");
        $("#matr").text(data.matr);
        $("#profile-name").text(data.name);
        $("#profile-email").text(data.username);
        $("#surname").text(data.surname);
        //$("#email-private");
        //$("#birthday").text();
        //$("#birth-place");

        $("#welcome-title").text(data.name);

    });
}

/**
 * Append text (current page) breadcrumb on navigation-breadcrumbs
 * @type {Element}
 */
function addToBreadcrumbs(text) {
    if($("#navigation-breadcrumb li").last().text() != text) {
        var c = document.createElement("li");
        var link = document.createElement("a");
        link.href = "#";
        link.innerHTML = text;
        c.appendChild(link);
        $("#navigation-breadcrumb").append(c);
    }
}

function bindEventBreadcrumb(text, func){
    //console.log("entro.. testo: " + text, " funzione -> " + func);
    getBreadcrumb(text).bind('click',function (e) {
        func();
        e.preventDefault();
    });
}

function getBreadcrumb(text){
    /*console.log("T:"+text);
    console.log("preso elemento-->" + $("#navigation-breadcrumb li:contains('"+text+"')") );*/
    return $("#navigation-breadcrumb li:contains('"+text+"')");
}

function removeAllBreadcrubsAfter(text){
    while($("#navigation-breadcrumb li").last().text() != text){
        $("#navigation-breadcrumb li").last().remove();
    }
}

function returnToHome(){
    removeAllBreadcrubsAfter("Home");
}

/**
 * .on("load") executes when all the page (img included) is loaded.
 */
$(window).on("load", function() {

    /**
     * Loading Footer
     */
    $("#footer-content").load("/pages/footer.html");

    // Animate loader off screen
    $(".se-pre-con").delay(700).fadeOut("slow");

});

/**
 * Buttons callbacks bindings
 */
$("#tab_notifications").on('click', function () {
    $("#main-content").load("/pages/notifications.html");
});

$("#profile-btn").on('click', function () {
    returnToHome();
    addToBreadcrumbs("Profile");
    $("#main-content").load("/pages/profile.html");
    loadProfileInfo();
});

function loadEventPage() {
    $("#main-content").load("/pages/cusb/events.html");
}

function loadTournamentPage() {
    $("#main-content").load("/pages/cusb/tournaments.html");
}

function loadTrainingPage() {
    $("#main-content").load("/pages/cusb/trainings.html");
}

function cusb_main_ref() {
    returnToHome();
    addToBreadcrumbs("Cusb");

    $("#main-content").load("/pages/cusb/home-cusb.html", function (e) {

        bindEventBreadcrumb("Cusb",cusb_main_ref);

        $("#events-link").on('click', function (e) {
            addToBreadcrumbs("Eventi");
            bindEventBreadcrumb("Eventi",loadEventPage);
            loadEventPage();
        });

        $("#tournaments-link").on('click', function (e) {
            addToBreadcrumbs("Tornei");
            $("#main-content").load("/pages/cusb/tournaments.html");
            e.preventDefault();
        });

        $("#training-link").on('click', function (e) {
            addToBreadcrumbs("Allenamenti");
            $("#main-content").load("/pages/cusb/trainings.html");
            e.preventDefault();
        });

        $("#subscriptions-link").on('click', function (e) {
            addToBreadcrumbs("Iscrizioni");
            $("#main-content").load("/pages/cusb/subscriptions.html");
            e.preventDefault();
        });
    });
}


$("#cusb").on('click',function () {
    cusb_main_ref();
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

/**
 * Set Table property
 */
function initTable(table_id) {
    var t_data = 0;

    if ( $.fn.dataTable.isDataTable( '#table_id' ) ) {
        t_data = $("#" + table_id).DataTable();
    }
    else {
        t_data = $("#" + table_id).DataTable({
                "language": {
                    "decimal": "",
                    "emptyTable": "Dati non disponibili",
                    "infoPostFix": "",
                    "thousands": ",",
                    "loadingRecords": "Caricamento...",
                    "processing": "Elaborazione...",
                    "search": "Cerca:",
                    "lengthMenu": "Mostra _MENU_ per pagina",
                    "zeroRecords": "Nessun risultato",
                    "info": "Pagina _PAGE_ di _PAGES_",
                    "infoEmpty": "Nessun risultato",
                    "infoFiltered": "(filtrato tra _MAX_ risultati totali)",
                    "paginate": {
                        "first": "Primo",
                        "last": "Ultimo",
                        "next": "Avanti",
                        "previous": "Indietro"
                    },
                    "aria": {
                        "sortAscending": ": ordina ascendente",
                        "sortDescending": ": ordina discendente"
                    }
                }
            }
         );
    }
    return t_data;
}

function buttonFilterTable(table, filter){
    if ($(filter).text().toLowerCase() == "reset") {
        table.search("").draw();
    } else {
        table.search($(filter).text().toLocaleLowerCase()).draw();
    }
}

/**
 * Load modal from file
 */
function loadModal() {
    if(!$('.result-modal').length) {
        $(document.body).append("<div id='result-modal'></div>");
    }
    $("#result-modal").load("modal.html");
}