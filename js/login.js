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

    $("#login-submit").click(function (event) {


    });

});
