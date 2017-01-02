<?php
/**
 * Created by PhpStorm.
 * User: Carlo Alberto
 * Date: 31/12/16
 * Time: 00:25
 */

require_once 'db_conn.php';
secure_session_start();

/*
Funzione che crea una sessione php sicura
*/
function secure_session_start(){
    $sec_session_name = 'sec_session';
    $secure = false; //set true if SSL/TSL
    $httponly = true;
    ini_set('session.use_only_cookies', 1);
    $cookie_params = session_get_cookie_params();
    session_set_cookie_params($cookie_params["lifetime"],$cookie_params["path"],$cookie_params["domain"],$secure, $httponly);
    session_name($sec_session_name);
    session_start();
    session_regenerate_id();
}

function controllo_cookie_member(){
    global $db;
	if(isset($_COOKIE['session'])){
		//prendo username e md5(password) presente nel cookie
		$tmp=preg_split("_&&_", $_COOKIE['session']);
		$tmp[0] = urldecode($tmp[0]);
		$tmp[0] = str_replace("_", "",$tmp[0]);
		$tmp[1] = str_replace("_", "",$tmp[1]);
		if(count($tmp)!=2) {
			return false;
		}
		//confronto username e password del cookie con il database
        $query ="SELECT * from `member` where username='$tmp[0]' and password='$tmp[1]'";
		$result = $db->query($query);
        if( $result->num_rows> 0 ) {
			$row= $result->fetch_row();
			//immagazzinano le informazioni dell'utente in un array
			$_SESSION["username"]=$row["username"];
			//$_SESSION["password"]=$row["password"];
			$_SESSION["authority"]=="member";
			return true;
		} else
			return false;
	} else
		return false;
}
/*
function controllo_cookie_admin2(){
	if(isset($_COOKIE['session'])){
		//prendo username e md5(password) presente nel cookie
		$tmp=split("_&&_", $_COOKIE['session']);
		if(count($tmp)!=2) {
			return false;
		}
		//confronto username e password del cookie con il database
		$query=mysql_query("SELECT * from `admins` where username='$tmp[0]' and password='$tmp[1]'")or die("Query non valida: " . mysql_error());;
		if( mysql_num_rows($query) > 0 ) {
			$row=mysql_fetch_array($query);
			//immagazzinano le informazioni dell'utente in un array
			$$_SESSION["username"]=$row["username"];
			$$_SESSION["password"]=$row["password"];
			$$_SESSION["authority"]=="root";
			return true;
		} else
			return false;
	} else
		return false;
}

function controllo_cookie_organizer2(){
	if(isset($_COOKIE['session'])){
		//prendo username e md5(password) presente nel cookie
		$tmp=split("_&&_", $_COOKIE['session']);
		if(count($tmp)!=2) {
			return false;
		}
		//confronto username e password del cookie con il database
		$query=mysql_query("SELECT * from `Organizer` where username='$tmp[0]' and password='$tmp[1]'")or die("Query non valida: " . mysql_error());;
		if( mysql_num_rows($query) > 0 ) {
			$row=mysql_fetch_array($query);
			//immagazzinano le informazioni dell'utente in un array
			$$_SESSION["username"]=$row["username"];
			$$_SESSION["password"]=$row["password"];
			$$_SESSION["authority"]=="organizer";
			return true;
		} else
			return false;
	} else
		return false;
}

function controllo_cookie_trainer2(){
	if(isset($_COOKIE['session'])){
		//prendo username e md5(password) presente nel cookie
		$tmp=split("_&&_", $_COOKIE['session']);
		if(count($tmp)!=2) {
			return false;
		}
		//confronto username e password del cookie con il database
		$query=mysql_query("SELECT * from `Trainer` where username='$tmp[0]' and password='$tmp[1]'")or die("Query non valida: " . mysql_error());;
		if( mysql_num_rows($query) > 0 ) {
			$row=mysql_fetch_array($query);
			//immagazzinano le informazioni dell'utente in un array
			$$_SESSION["username"]=$row["username"];
			$$_SESSION["password"]=$row["password"];
			$$_SESSION["authority"]=="trainer";
			return true;
		} else
			return false;
	} else
		return false;
}

?>*/
