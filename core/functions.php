<?php
/**
 * Created by PhpStorm.
 * User: Carlo Alberto
 * Date: 31/12/16
 * Time: 00:25
 */

require_once 'db_conn.php';

/*
Funzione che aggiunge al db un log, quando un utente cerca di effettuare login ma non va a buon fine.
*/
function failedLoginLog($username,$password,$ip_addr){
    global $db;
    $time = time();
    $q = "INSERT into `login_attempts` (user_id,password_tried,time,ip) values ('$username','$password','$time','$ip_addr')";
    if(!$db->query($q)){
        die("error failedLogin");
    }
}

/*
Function for logging user logins.
*/
function logLogin($username, $ip_addr){
    global $db;
    $time = time();

    $query = "INSERT into `login_history` (member,ip) values ('$username','$ip_addr')";
    if(!$db->query($query)){
        die("error loglogin");
    }
}

function cacheLoginInfo($row){
    var_dump($row);
    $_SESSION["logged"]= true;
    $_SESSION["username"] = $row["username"];
    $_SESSION["password"] = $row["password"];
    $_SESSION["email"] = $row["username"];
    $_SESSION["surname"] = $row["surname"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["address"] = $row["address"];
    $_SESSION["sex"] = $row["sex"];

    /*$_SESSION["city"] = $row["city"];

    $_SESSION["birthday_date"] = $row["birthday_date"];
    $tmp = split("-", $_SESSION["birthday_date"]);
    $_SESSION["birthday_year"] = $tmp[0];
    $_SESSION["birthday_month"] = $tmp[1];
    $_SESSION["birthday_day"] = $tmp[2];*/

}

function getLoginInfo($username,$password){
    global $db;
    //$array = array("member","Organizer","Trainer","admins");
    $array = array("member");
    foreach ($array as $type ){
        $query = "SELECT * from `".$type."` WHERE username='$username' AND password='$password'";
        $res = $db->query($query);
        if ($res->num_rows > 0) {
            $s = $res->fetch_array();
            cacheLoginInfo($s);
            if ($type=="member"){
                $_SESSION["authority"] = "member";
            } else if ($type=="Organizer"){
                $_SESSION["authority"] = "organizer";
            } else if ($type=="Trainer"){
                $_SESSION["authority"] = "trainer";
            } else if ($type=="admins"){
                $_SESSION["authority"] = "root";
            }
            return true;
        }
    }
    $res->free_result();
    return false;
}
/*
function retrieve_password($username, $email, $authority){
    if ($authority=="organizer") $param="Organizer";
    if ($authority=="trainer") $param="Trainer";
    if ($authority=="member") $param="member";
    $q = mysql_query("SELECT password FROM `".$param."` WHERE username='$username' AND email='$email'") or die("Query non valida: " . mysql_error());
    $ret = mysql_fetch_array($q);
    return $ret["password"];
}*/

function update_values($name,$surname,$city,$address,$birthday_date,$email,$new_password){
    $_SESSION["name"] = $name;
    $_SESSION["surname"] = $surname;
    $_SESSION["city"] = $city;
    $_SESSION["email"] = $email;
    $_SESSION["birthday_date"] = $birthday_date;
    $_SESSION["password"] = $new_password;
}


function getLastLogin($username){
    global $db;
    $q = "SELECT `data` FROM `login_history` where member='$username' ORDER BY data DESC LIMIT 1";
    $res = $db->query($q);
    if (!$res){
        echo "ERROR+++".$db->error."<br>";
    }
    $last_login = $res->fetch_assoc();
    $res->free_result();
    return $last_login['data'];
}

/*
Funzione che controlla gli ultimi n. tentativi di accesso e se questi superano un numero stabilito
blocca completamente l'accesso a quel determinato indirizzo ip per un certo periodo di tempo. (5min)
*/
function checkBruteforce($ip_addr){
    global $db;
    $limit_time = time() - 120;			 //tempo limite per user-block-out
    $sql = "SELECT `time` FROM `login_attempts` WHERE ip='$ip_addr' AND `time` >'$limit_time'";
    //$query = mysql_query("SELECT `time` FROM `login_attempts` WHERE ip='$ip_addr' AND `time` >'$limit_time'") or die ("ERROR QUERY ". mysql_error());
    $res = $db->query($sql);
    $row = $res->num_rows;
    if ( $row > 3 ) {
        return true;
    }
    $res->free_result();
    return false;
}


/*
Funzione che sanitizza l'input per impedire attacchi di tipo SQL Injection
	$bool --> True (elimina gli spazi)
		  --> False (tiene gli spazi)
*/
function sanitize($login, $bool){ 
	if($bool){
		$login=str_replace(" ","",$login);
	}
	$login=str_replace(";","",$login);
	$login=str_replace(":","",$login);
	$login=str_replace(",","",$login);
	$login=str_replace("'","",$login);
	$login=str_replace("*","",$login);
	$login=str_replace("?","",$login);
	$login=str_replace("=","",$login);
	$login=str_replace("&","",$login);
	$login=str_replace("%","",$login);
	$login=str_replace("$","",$login);
	$login=str_replace("<","",$login);
	$login=str_replace(">","",$login);
	$login=str_replace("#","",$login);
	return $login;
}

/*
Funzione check per data (month,day,year)
*/
function check_Date($month,$day,$year){
	if (strlen($month)==0 || strlen($month) > 2 || (is_numeric($month)!=1) ) {
		echo "month invalid";
		return false;
	}
	if (strlen($day)==0 || strlen($day) > 2 || (is_numeric($day)!=1) ) {
	 	echo "DAY INVALID";
		return false;
	}
	if (strlen($year)!=4 || (is_numeric($year)!=1) ){
		echo "YEAR INVALID";
		return false;
	}
	if(checkdate($month,$day,$year)){
		return true;
	} else {
		return false;
	}
}


/*
Funzione che controlla che la password non contenga caratteri "pericolosi", in caso affermativo torna True
*/
function badPsw($password){
	$prevPsw = $password;
	$password = sanitize($password);
	return (strlen($prevPsw) > strlen($password));
}
