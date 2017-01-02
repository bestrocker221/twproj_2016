<?php
/**
 * Created by PhpStorm.
 * User: Carlo Alberto
 * Date: 31/12/16
 * Time: 00:25
 */
require_once 'db_conn.php';
require_once 'cookie_check.php';
require_once 'functions.php';

secure_session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(checkBruteforce($_SERVER['REMOTE_ADDR'])){
        //TODO
        header("location: /basi/login-register/bann.php");
        die;
    }
    $username = sanitize($_POST['username'],true);
    $password = md5(sanitize($_POST['hash-psw'],true));

    //$q = mysql_query("SELECT * from `members` WHERE username='$username' AND password='$password'",$conn) or die("Query non valida: " . mysql_error());

    if(getLoginInfo($username,$password)){
        echo "setto cookie --> user: ". $_SESSION["username"];
        $cookie_time = 3600*24*7;
        $sess_cookie = session_get_cookie_params();
        setcookie('session', $_SESSION["username"].'_&&_'.$_SESSION["password"],
            time()+$cookie_time,$sess_cookie["path"],$sess_cookie["domain"],
            $sess_cookie["secure"],true);
        $_SESSION["last_login"] = getLastLogin($username);
        logLogin($username,$_SERVER['REMOTE_ADDR']);
        if ($_SESSION["authority"] != "member"){
            //header("location: /basi/admin_pan.php");
        } else {
            header("location: /index.php");
            echo "FUNZIA";
        }
    } else {
        failedLoginLog($username,$_POST['password'],$_SERVER['REMOTE_ADDR']);
        $_SESSION["logged"]=false;
        header("location: login_failed.html");
    }
}

