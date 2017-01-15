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
    session_set_cookie_params($cookie_params["lifetime"],$cookie_params["path"],
        $cookie_params["domain"],$secure, $httponly);
    session_name($sec_session_name);
    session_start();
    session_regenerate_id();
}



/*
Funzione che aggiunge al db un log, quando un utente cerca di effettuare login ma non va a buon fine.
*/
function failedLoginLog($username,$password,$ip_addr){
    global $db;
    $time = time();
    $q = "INSERT into `login_attempts` (user_id,password_tried,time,ip) 
            values ('$username','$password','$time','$ip_addr')";
    if(!$db->query($q)){
        die("error failedLogin");
    }
}

/*
Function for logging user logins.
*/
function logLogin($username, $ip_addr){
    global $db;
    $query = "INSERT into `login_history` (member,ip) values ('$username','$ip_addr')";
    if(!$db->query($query)){
        die("error loglogin");
    }
}

function cacheLoginInfo($row){
    $_SESSION["logged"]= true;
    $_SESSION["email"] = $row["username"];
    $_SESSION["surname"] = $row["surname"];
    $_SESSION["name"] = $row["name"];
    $_SESSION["address"] = $row["address"];
    $_SESSION["sex"] = $row["sex"];

    /*
    $_SESSION["city"] = $row["city"];
    $_SESSION["birthday_date"] = $row["birthday_date"];
    $tmp = split("-", $_SESSION["birthday_date"]);
    $_SESSION["birthday_year"] = $tmp[0];
    $_SESSION["birthday_month"] = $tmp[1];
    $_SESSION["birthday_day"] = $tmp[2];
    */

}

/**
 * Check if a user has permissions (logged in)
 * @return bool
 */
function checkLogin(){
    global $db;
    if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.

        if ($stmt = $db->prepare("SELECT password FROM member WHERE ID_Member = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id); // esegue il bind del parametro '$user_id'.
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows == 1) { // se l'utente esiste

                $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
                $stmt->fetch();
                $login_check = hash('sha512', $password.$user_browser);
                if($login_check == $login_string) {
                    // Login eseguito!!!!
                    return true;
                } else {
                    //  Login non eseguito
                    return false;
                }
            } else {
                // Login non eseguito
                return false;
            }
        } else {
            // Login non eseguito
            return false;
        }
    } else {
        // Login non eseguito
        return false;
    }
}


function getLoginInfo($username,$password /*X*/){
    global $db;
    //$array = array("member","Organizer","Trainer","admins");
    $array = array("member");

    foreach ($array as $type ){

        if($stmt = $db->prepare("SELECT * from `".$type."` WHERE username=?")){
            $stmt->bind_param("s",$username);
            $stmt->execute();

            $res = $stmt->get_result();
            if($res->num_rows > 0){

                $s = $res->fetch_array(MYSQLI_ASSOC);

                $newPsw = hash('sha512',$password.$s['salt']); //E

                if($newPsw == $s['password']){

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $newPsw.$_SERVER['HTTP_USER_AGENT']);
                    $_SESSION['user_id'] = $s['ID_Member'];
                    $_SESSION['mat'] = $s['mat'];
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
            $stmt->close();
        }
    }
    return false;
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
function sanitize($login, $bool = false){
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
