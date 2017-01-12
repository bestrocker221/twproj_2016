<?php
/**
 * Created by PhpStorm.
 * User: Carlo Alberto
 * Date: 31/12/16
 * Time: 00:25
 */
require_once 'db_conn.php';
require_once 'functions.php';

secure_session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(checkBruteforce($_SERVER['REMOTE_ADDR'])){
        echo "BANN";//TODO
        die;
    }
    $username = sanitize($_POST['username'],true);
    $password = sanitize($_POST['hash-psw'],true);

    if(getLoginInfo($username,$password)){

        $cookie_time = 3600*24*7;
        $sess_cookie = session_get_cookie_params();

        setcookie('session', "",
            time()+$cookie_time,$sess_cookie["path"],$sess_cookie["domain"],
            $sess_cookie["secure"],true);
        $_SESSION["last_login"] = getLastLogin($username);

        logLogin($username,$_SERVER['REMOTE_ADDR']);

        if ($_SESSION["authority"] != "member"){
            //non è membro
        } else {
            //è membro
            echo "OK";
        }
    } else {
        failedLoginLog($username,$_POST['password'],$_SERVER['REMOTE_ADDR']);

        $_SESSION["logged"]=false;

        echo "LOGIN FAILED";
    }
}

$db->close();