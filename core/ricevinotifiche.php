<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 16/12/16
 * Time: 10:45
 */

$db = new mysqli("wittygetty.ddns.net:50333","user_cusb","cusb_official.2016","cusb2016");
if($db->connect_errno){
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
    //echo "OK";

    $id = $_GET["id"];

    $sql = "SELECT description, date, showed FROM notifications WHERE id='$id'";
    $sql2 = "SELECT COUNT(*) FROM notifications WHERE id_member='$id'";

    $tot = array();

    $result =$db->query($sql);
    if($result->num_rows > 0){
        $tot['val'] = $result->fetch_assoc();
    } else {
        echo "ERROR1 " . $db->error;
    }
    $result =$db->query($sql2);
    if($result->num_rows == 1){
        $tot['total'] = $result->fetch_row()[0];
    } else {
        echo "ERROR2 " . $db->error;
    }

    $tot = json_encode($tot);
    echo $tot;
}