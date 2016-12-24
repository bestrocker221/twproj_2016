/**
 * Created by CarloAlberto on 13/12/16.
 */
$(function (){
/*
    $("#login-form-link").click(function (event) {
        $('#login-form').delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $("#register-form-link").removeClass("active");
        $(this).addClass('active');
        event.preventDefault();
    });


    $("#register-form-link").click(function (event) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $("#login-form-link").removeClass("active");
        $(this).addClass("active");
        event.preventDefault();
    });
*/
    $('.alert .close').on('click', function(e) {
        //$(this).parent().hide();
        $(this).parent().fadeOut(400);
        $("#row-user").removeClass("has-error has-feedback");
        $("#row-password").removeClass("has-error has-feedback");
        /*
        $("#row-name").removeClass("has-error has-feedback");
        $("#row-surname").removeClass("has-error has-feedback");
        $("#row-email").removeClass("has-error has-feedback");
        $("#row-address").removeClass("has-error has-feedback");
        $("#row-psw").removeClass("has-error has-feedback");
        */
    });

    //LOGIN BUTTON ROUTINE
    $("#login-submit").click(function (event) {
        if($("#username").val().length < 8){
            $("#error-div").fadeIn(150);
            addWarningToElement($("#row-user"));
        } else if($("#password-login").val().length < 8) {
            $("#error-div").fadeIn(150);
            addWarningToElement($("#row-password"));
        }
        event.preventDefault();
    });

    function addWarningToElement(elem){
        elem.addClass("has-error has-feedback");
    }

    function activateAlert(){
        $("#error-div-register").fadeIn(150);
    }

    /*
    function toggleWarningsOn() {
        var ok = 0;
        if($("#name").val().length < 5){
           ok = 1;
           addWarningToElement($("#row-name"));
        }
        if($("#surname").val().length < 5){
            ok = 1;
            addWarningToElement($("#row-surname"));
        }
        if($("#email-register").val().length < 5){
            ok = 1;
            addWarningToElement($("#row-email"));
        }
        if($("#address").val().length < 5){
            ok = 1;
            addWarningToElement($("#row-address"));
        }
        if($("#password").val().length < 5){
            ok = 1;
            addWarningToElement($("#row-psw"));
        }
        if(ok!=0){
            activateAlert();
        }
    }

    //REGISTER BUTTON ROUTINE
    $("#register-submit").on('click', function (e) {
        toggleWarningsOn();
        e.preventDefault();
    })

    */
});
