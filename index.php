<?php
require_once 'core/functions.php';
secure_session_start();
if (checkLogin()){

} else {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Alma Studenti - Unibo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet prefetch' href='css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
</head>

<body>
<div class="se-pre-con"></div>

<?php include "pages/header.html"?>

<div class="container-fluid">
    <div id="wrapper" class="toggled row" >
        <!-- Sidebar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
                    <ul class="nav sidebar-nav">
                        <li class="sidebar-brand">
                            <a title="name" id="name" href="#" style="background: #1a1a1a;"></a>
                        </li>
                        <li><a href="#">Prove d'ammissione</a></li>
                        <li><a href="#">Immatricolazioni</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Carriera
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Sotto sezioni..</li>
                                <li><a href="#">AlmaEsami</a></li>
                                <li><a href="#">Libretto Online</a></li>
                                <li><a href="#">Certificati</a></li>
                                <li><a href="#">Piani di Studio</a></li>
                                <li><a href="#">Passaggio di corso</a></li>
                                <li><a href="#">Laurea</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Bandi</a></li>
                        <li><a href="#">Tasse Iscrizione</a></li>
                        <li><a href="#" id="cusb">Cusb</a></li>
                        <li><a href="#">Idoneità Linguistica</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gestione Studi
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="dropdown-header">Sotto sezioni..</li>
                                <li><a href="#">Trasferimento</a></li>
                                <li><a href="#">Sospensione studi</a></li>
                                <li><a href="#">Rinuncia agli studi</a></li>
                            </ul>
                        </li>
                        <li><a href="/crea.html">Alma Orienta</a></li>
                    </ul>
                </nav>
        <!-- /#sidebar-wrapper -->

        <div class="col-lg-12">
            <!-- MainNavbar -->
            <nav>
                <div class="row" id="nav-options" style="z-index:100">
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 myHamb">
                        <button type="button" class="hamburger is-open" data-toggle="offcanvas" style="margin-top: 6px;">
                            <span class="hamb-top"></span>
                            <span class="hamb-middle"></span>
                            <span class="hamb-bottom"></span>
                        </button>
                    </div>
                    <!-- Central nav logo -->
                    <div class="col-lg-offset-3 col-lg-3 col-md-offset-2 col-md-3 col-sm-offset-1 col-sm-3" style="line-height: 3.0em;">
                        <div class="myTrajanFont">
                            <strong id="logo-nav" style="font-size: 16px;">
                                <a href="/">ALMA
                                    <img src="/res/unibo_logo.png" alt="Logo unibo">
                                    STUDENTI</a>
                            </strong>
                        </div>
                    </div>
                    <!-- #/Central nav logo -->
                    <!-- Notifiche -->
                        <div class="col-lg-offset-1 col-lg-4 col-md-offset-0 col-md-6 col-sm-offset-0 col-sm-7 col-xs-offset-3 col-xs-8">
                        <div class="navbar-header">
                            <ul class="nav navbar-nav ">
                                <li id="not-toggle" class="dropdown menu-parent">
                                    <a  href="#" class="dropdown-toggle" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-bell"></span>
                                        <span id="total_not" class="badge"></span>
                                    </a>
                                    <ul id="notification_list" role="menu" class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" >
                                        <li hidden><a></a></li>
                                        <li class="message-preview" id="not-template" hidden>
                                            <a href="">
                                                <div class="not-media">
                                                    <h5 class="media-heading" >
                                                        <strong id="not-title">Title</strong>
                                                    </h5>
                                                    <p class="small text-muted text-right" >
                                                        <strong class="fa fa-clock-o" id="not-date"> date</strong>
                                                    </p>
                                                    <p id="not-body">
                                                        body
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li id="view-all" role="presentation"><a id="tab_notifications">Visualizza tutte</a> </li>
                                    </ul>
                                </li>
                                <li id="prof-toggle" class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-user"></span> 
                                    </a>
                                    <ul class="dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <div class="navbar-login">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="text-center">
                                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <p class="text-left text-center"><strong id="member-name">Scola Carlo Alberto</strong></p>
                                                        <p class="text-left small text-center">
                                                            <a id="member-email" href="mailto:carloalberto.scola@studio.unibo.it">carloalberto.scola@studio.unibo.it</a></p>
                                                        <p class="text-left">
                                                            <a id="profile-btn" href="#" class="btn btn-primary btn-block btn-sm">Profilo</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <div class="navbar-login navbar-login-session">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p>
                                                            <a id="logout-btn" href="/core/logout.php" class="btn btn-danger btn-block">Log out</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="myTrajanFont">
                                    <a href="/core/logout.php">
                                        <span class="glyphicon glyphicon-log-out"></span> Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /#Notifiche -->
                </div>
            </nav>
            <!-- /#MainNavbar -->
            <div class="row" style="margin-top: 60px; z-index: -1">
                <!-- Page Content -->
                <div id="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10 col-lg-offset-1 col-md-offset-1 col-md-11 col-sm-offset-1 col-sm-11 col-xs-offset-1 col-xs-11">
                                <!-- Breadcrumbs -->
                                <div class="row">
                                    <ul id="navigation-breadcrumb" class="breadcrumb">
                                        <li><a id="home-btn" href="/">Home</a></li>
                                    </ul>
                                </div>
                                <!-- /#Breadcrumbs -->
                                <!-- Interchangeable content -->
                                <main>
                                    <div id="main-content" class="row"></div>
                                </main>
                                <!-- /#Interchangeable content -->
                            </div>
                        </div>
                        <!-- Footer-->
                        <div id="footer-content" class="row">
                            <?php include "pages/footer.html";?>
                        </div>
                        <!-- /#Footer -->

                    </div>
                </div>
                <!-- /#page-content-wrapper -->
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->
<link rel="stylesheet" href="/css/animate.min.css">
<!-- Including scripts -->
<script src='js/jquery-3.1.1.min.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src='js/calendar/moment.js'></script>
<script src="js/jquery.bootstrap.newsbox.min.js"></script>
<script src="js/home.js"></script>
<!-- /# Finish scripts includes -->
</body>
</html>