<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 19/12/16
 * Time: 19:00
 */
require "db_conn.php";

//crea nuova notifica
if(isset($_POST['id']) && isset($_POST['desc'])){
    $id = $_POST["id"];
    $desc = $_POST["desc"];

    $sql = "INSERT INTO notifications (id_member,description) VALUES ('$id','$desc')";
    if($db->query($sql) === TRUE){
        echo "OK";
    } else {
        echo "ERROR " . $db->error;
    }
}
//riceve notifiche
else if (isset($_GET["id"])){
    $id = $_GET['id'];

    $sql = "SELECT description, date, showed FROM notifications WHERE id_member='$id' LIMIT 6";
    $sql2 = "SELECT COUNT(*) FROM notifications WHERE id_member='$id'";

    $tot = array();
    if(!$db){
        echo "NO DB";
    }
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $num = $result->num_rows;
        for( $k=0;$k<$num;$k++){
            array_push($tot,$result->fetch_row());
        }
    } else {
        echo "ERROR1 " . $db->errno;
        echo "num row" . $result->num_rows;
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