<?php
/**
 * Created by bsod.
 * User: bsod
 * Date: 12/12/16
 * Time: 22:06
 */
$db = new mysqli("wittygetty.ddns.net:50333","user_cusb","cusb_official.2016","cusb2016");
if($db->connect_errno){
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
    echo "OK";
}
