/**
 * Created by bsod on 13/12/16.
 */
$(function (){

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

    $('.alert .close').on('click', function(e) {
        //$(this).parent().hide();
        $(this).parent().fadeOut(400);
    });

    $("#login-submit").click(function (event) {
        console.log("entro");
        if($("#username").val().length < 8){
            console.log("entro2");
            $("#error-div").fadeIn(150);
            $("#row-user").addClass("has-error");
            $("#row-user").addClass("has-feedback");
        } else if($("#password").val().length < 8) {
            $("#error-div").fadeIn(150);
            $("#row-password").addClass("has-error");
            $("#row-password").addClass("has-feedback");
        }
        event.preventDefault();
    });

});
