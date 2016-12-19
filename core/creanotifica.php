<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 16/12/16
 * Time: 10:22
 */

$db = new mysqli("wittygetty.ddns.net:50333","user_cusb","cusb_official.2016","cusb2016");
if($db->connect_errno){
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
    //echo "OK";

    $id = $_POST["id"];
    $desc = $_POST["desc"];

    $sql = "INSERT INTO notifications (id_member,description) VALUES ('$id','$desc')";
    if($db->query($sql) === TRUE){
        echo "OK";
    } else {
        echo "ERROR " . $db->error;
    }
}