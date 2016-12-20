<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 19/12/16
 * Time: 19:00
 */

/**
 * Object Oriented Connection
 */
$db = new mysqli("wittygetty.ddns.net:50333","user_cusb","cusb_official.2016","cusb2016");
if($db->connect_errno){
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

/**
 * Procedural Connection
 */