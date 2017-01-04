<?php
/**
 * Created by PhpStorm.
 * User: CarloAlberto
 * Date: 29/12/16
 * Time: 12:00
 */

require_once 'db_conn.php';
require_once 'functions.php';

secure_session_start();

if(checkLogin()) {
//make request to the server, must retrieve json format and with

    $id = $_SESSION['user_id'];

    $sql = "SELECT id, title, url, start, end FROM `general_events` WHERE id_member='$id'";

    $result = $db->query($sql);
    $tot = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temp = array();
            $temp['id'] = $row['id'];
            $temp['title'] = $row['title'];
            $temp['url'] = $row['url'];
            $temp['start'] = $row['start'];
            $temp['end'] = $row['end'];

            array_push($tot, $temp);
        }

        /*$num = $result->num_rows;
        for( $k=0;$k<$num;$k++){
            array_push($tot,$result->fetch_row());
        }*/
    } else {
        echo "ERROR " . $db->errno;
        echo "num row" . $result->num_rows;
    }
    $tot = json_encode($tot);
    echo $tot;
}