<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 30/12/16
 * Time: 17:16
 */
require '../db_conn.php';

//$id = $_SESSION['member-id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = 6;

    $sqlA = "SELECT * from Trainings";
    $sqlB = "SELECT ID_training from follow_Tr WHERE ID_Member='$id'";

    $tot = array();

    $temp2 = array();
    $result = $db->query($sqlB);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temp2[$row['ID_training']] = "yes";
        }
    }

    $result = $db->query($sqlA);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temp = array();
            $temp['id_training'] = $row['ID_training'];
            $temp['of_what'] = $row['of_what'];
            $temp['date'] = $row['date'];
            if (array_key_exists($temp['id_training'], $temp2)) {
                $temp['iscritto'] = "yes";
                unset($temp2[$temp['id_training']]);
            }
            array_push($tot, $temp);
        }
    } else {
        echo "ERROR " . $db->errno;
        echo "num row" . $result->num_rows;
    }
    $tot = json_encode($tot);
    echo $tot;
} else if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $id = 6;

    if(isset($_POST['id-training'])) {
        $id_training = htmlspecialchars($_POST['id-event']);

        $sql = "INSERT INTO follow_Tr (ID_training,ID_Member) VALUES ('$id_training','$id')";
        if($db->query($sql) === true){
            echo "OK";
        } else {
            echo "ERROR " . $db->errno;
        }
    }

}