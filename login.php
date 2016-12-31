<?php
require_once 'core/functions.php';
require_once 'core/cookie_check.php';
secure_session_start();
$tmp = preg_split("_&&_", $_COOKIE['session']);
$tmp[0] = urldecode($tmp[0]);
echo str_replace("_", "",$tmp[0]);
echo "</br>";
echo str_replace("_", "",$tmp[1]);
if (controllo_cookie_member()){
    header("location: /index.php");
} else {
    echo "user: lampa@dina.it</br>pwd: lampadina";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="application/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
    <script src="js/sha512.js"></script>
    <title>Login</title>
</head>
<body>
<script>
    $(document).ready(function () {
        $("#login-submit").bind("click", function (e) {

            $("#password-login").val(hex_sha512($("#password-login").val()));
            $("#login-form").submit();
        })
    });
</script>
    <div class="container" style="padding-top: 60px;">
        <div class="row" >
            <div class="col-md-6 col-md-offset-3 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6 group-login">
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
                                <form class="form-horizontal" id="login-form" action="/core/check_login.php" method="post" role="form" style="display:block;">
                                    <div id="row-user" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <label for="username" hidden>Username</label>
                                        <input class="form-control" autofocus autocomplete="yes" placeholder="Email Istituzionale" tabindex="1" value="" type="text" name="username" id="username" >
                                    </div>
                                    <div id="row-password" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <label for="password-login" hidden>Password</label>
                                        <input class="form-control" placeholder="Password" value="" tabindex="2" type="password" name="password" id="password-login" >
                                    </div>
                                    <!-- error messages -->
                                    <div id="error-div" class="alert alert-danger alert-dismissible fade in" style="display: none; margin-top: 10px;">
                                        <a href="#" class="close" aria-label="close">&times;</a>
                                        <strong>Errore!</strong><span id="error-msg"> Mancano informazioni per procedere (minimo 8 caratteri) </span>
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
    <!--
    <div class="illustrationClass"></div>
    -->
</body>
</html>