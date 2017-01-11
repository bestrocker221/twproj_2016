<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 11/01/17
 * Time: 00:04
 */
require_once 'db_conn.php';
require_once 'functions.php';

secure_session_start();

if(checkLogin()) {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['text']) && isset($_POST['date']) && isset($_POST['id'])){

            $id = sanitize($_POST['id']);
            $text = sanitize($_POST['text']);
            $date = explode("T",$_POST['date']);

            $sql = "INSERT into general_events (title,start,id_member) VALUES ('$text','$date[0]','$id')";
            if($db->query($sql) === TRUE){
                echo "OK!!";
            } else {
                echo $db->errno;
                echo $db->error;
            }
        }

    }
}