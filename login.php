<?php
require_once 'core/functions.php';
secure_session_start();
if (checkLogin()){
    header("location: /index.php");
    echo "fatto";
} else {
    echo "user: lampa.dina@studio.unibo.it</br>pwd: lampadina";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="application/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sha512.js"></script>
    <title>Unibo - Login</title>
</head>
<body>
<script>
    $(document).ready(function () {
        $('.alert .close').on('click', function(e) {
            //$(this).parent().hide();
            $(this).parent().fadeOut(400);
            $("#row-user").removeClass("has-error has-feedback");
            $("#row-password").removeClass("has-error has-feedback");
        });

        //LOGIN BUTTON ROUTINE
        $("#login-submit").click(function (event) {
            if($("#username").val().length < 8){
                $("#error-div").fadeIn(150);
                addWarningToElement($("#row-user"));
            } else if($("#password-login").val().length < 8) {
                $("#error-div").fadeIn(150);
                addWarningToElement($("#row-password"));
            } else {
                $("#hash-psw").val(hex_sha512($("#password-login").val()));
                $("#password-login").val("");

                //console.log($("#hash-psw").val());

                $.post("/core/check_login.php", {"username":$("#username").val(), "hash-psw":$("#hash-psw").val()}, function (data) {
                    if(data == "OK"){
                        window.location.href = "/index.php";
                    } else {
                        $("#error-div2").fadeIn(150);
                        //console.log(data);
                    }
                });
            }

            event.preventDefault();
        });

        function addWarningToElement(elem){
            elem.addClass("has-error has-feedback");
        }
    });
</script>
    <div class="container" style="padding-top: 60px;">
        <div class="row" >
                <div class="col-md-6 col-md-offset-3 col-sm-offset-2 col-sm-8 col-xs-offset-1 col-xs-9 group-login">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-offset-4 col-xs-4">
                                <label for="login-form-link" hidden>Login</label>
                                <a href="#login" class="active" id="login-form-link">Login</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row" id="pwd-container">
                            <div class="col-lg-12">
                                <!-- LOGIN FORM -->
                                <form class="form-horizontal" id="login-form" action="/core/check_login.php" method="post" role="form" style="padding-top: 60px;">
                                    <div id="row-user" class="input-group">
                                        <span class="input-group-addon"><em class="glyphicon glyphicon-user"></em></span>
                                        <label for="username" hidden>Username</label>
                                        <input class="form-control" autofocus autocomplete="on" placeholder="Email Istituzionale" tabindex="1" value="" type="text" name="username" id="username" >
                                    </div>
                                    <div id="row-password" class="input-group">
                                        <span class="input-group-addon"><em class="glyphicon glyphicon-lock"></em></span>
                                        <label for="password-login" hidden>Password</label>
                                        <input class="form-control" placeholder="Password" value="" tabindex="2" type="password" name="password" id="password-login" >
                                    </div>
                                    <input type="hidden" id="hash-psw" name="hash-psw" value=""/>
                                    <!-- error messages -->
                                    <div id="error-div" class="alert alert-danger alert-dismissible fade in"  style="display: none; margin-top: 10px;">
                                        <a href="#" class="close" aria-label="close">&times;</a>
                                        <strong>Errore!</strong><span id="error-msg1"> Mancano informazioni per procedere (minimo 8 caratteri) </span>
                                    </div>
                                    <div id="error-div2" class="alert alert-danger alert-dismissible fade in"  style="display: none; margin-top: 10px;">
                                        <a href="#" class="close" aria-label="close">&times;</a>
                                        <strong>Errore!</strong><span id="error-msg2"> Username o password errati. Riprova, hai al massimo 3 tentativi.</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <label for="login-submit" hidden>Log in</label>
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="3" class="form-control btn btn-login" value="Log in" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <label for="forgot-password" hidden>Forgot password?</label>
                                                    <a href="#s" tabindex="4" class="forgot-password" id="forgot-password">Password dimenticata?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="brandname">
                            <p class="titoletto">Alma Mater Studiorum</p>
                            <p class="nome">Università di Bologna</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>