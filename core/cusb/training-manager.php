<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 30/12/16
 * Time: 17:16
 */
require_once '../db_conn.php';
require_once '../functions.php';

secure_session_start();

if(checkLogin()) {

    $id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        //$id = 6;

        $sqlA = "SELECT * FROM Trainings";
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
                $field = "select name, place from Field where ID_field='".$row['ID_field']."'";
                $fres = $db->query($field);
                if($fres->num_rows == 1){
                    $r = $fres->fetch_assoc();
                    $temp['field_name'] = $r['name'];
                    $temp['field_place'] = $r['place'];
                }
                array_push($tot, $temp);
            }
        } else {
            echo "ERROR " . $db->errno;
            echo "num row" . $result->num_rows;
        }
        $tot = json_encode($tot);
        echo $tot;
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //$id = 6;

        if (isset($_POST['id-training'])) {
            $id_training = ($_POST['id-training']);

            $sql = "INSERT INTO follow_Tr (ID_training,ID_Member) VALUES ('$id_training','$id')";
            if ($db->query($sql) === true) {
                //insert into calendar
                $sql = "INSERT INTO `general_events`(`id_member`, `title`, `start`) 
                                VALUES ('$id',
                                  (SELECT of_what
                                    FROM Trainings
                                    WHERE ID_training='$id_training'),
                                  (SELECT date
                                    FROM Trainings
                                    WHERE ID_training='$id_training'))";
                if($db->query($sql) === TRUE) {
                    echo "tutte e due le query eseguite correttamente";
                } else {
                    echo "ERROR " . $db->errno;
                }
            } else {
                echo "ERROR " . $db->errno;
            }
        }
        //insert into calendar TODO

    }
}

$db->close();