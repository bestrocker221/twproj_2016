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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['text']) && isset($_POST['date']) && isset($_POST['id'])){

            $stmt = $db->prepare("INSERT into general_events (title,start,id_member) VALUES (?,?,?)");
            $stmt->bind_param("ssi", $text,$date,$id);

            $id = sanitize($_POST['id']);
            $text = sanitize($_POST['text']);
            $date = explode("T",$_POST['date']);
            $date = $date[0];

            $stmt->execute();
            $stmt->close();
        }

    } else {
//make request to the server, must retrieve json format and with


        $tot = array();

        $stmt = $db->prepare("SELECT id, title, url, start, end FROM `general_events` WHERE id_member=?");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($final_id,$title, $url, $start, $end);

        $id = $_SESSION['user_id'];

        if($stmt->execute()){
            while($row = $stmt->fetch()){
                $temp = array();
                $temp['id'] = $final_id;
                $temp['title'] = $title;
                $temp['url'] = $url;
                $temp['start'] =  $start;
                $temp['end'] =  $end;

                array_push($tot, $temp);
            }
        } else {
            echo "ERROR " . $db->errno;
            echo "num row" . $result->num_rows;
        }
        $stmt->close();

        $tot = json_encode($tot);
        echo $tot;
    }
}

$db->close();