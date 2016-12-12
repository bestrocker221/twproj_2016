<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 12/12/16
 * Time: 22:06
 */
$db = new mysqli("192.168.1.120","user_cusb","cusb_official.2016","cusb2016");
if($db->connect_errno){
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
    echo "OK";
}
