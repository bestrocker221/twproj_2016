<?php
/**
 * Created by PhpStorm.
 * User: Carlo Alberto
 * Date: 31/12/16
 * Time: 00:25
 */

require_once 'functions.php';

secure_session_start();
$_SESSION = array();
$params = session_get_cookie_params();
setcookie('session',null,time()-42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
session_destroy();
header('Location: /login.php');

$db->close();