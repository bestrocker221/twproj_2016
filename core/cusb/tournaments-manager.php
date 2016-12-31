<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 30/12/16
 * Time: 17:15
 */
require '../db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = 6;

    $sqlA = "SELECT * from Tournaments";
    $sqlC = "SELECT * from Tourn_Subsc WHERE ID_Member='$id'";

    $tot = array();

    $temp2 = array();
    $result = $db->query($sqlC);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temp2[$row['ID_torneo']] = $row['iscr_date'];
        }
    }

    $result = $db->query($sqlA);
    if ($result->num_rows > 0) {
        $atot = array();
        while ($row = $result->fetch_assoc()) {
            $temp = array();

            $temp['id_tourn'] = $row['ID_torneo'];
            $temp['date'] = $row['date'];
            $temp['n_player'] = $row['n_player'];
            $temp['of_what'] = $row['of_what'];
            $temp['id_field'] = $row['ID_field'];

            if (array_key_exists($row['ID_torneo'], $temp2)) {
                $temp['iscritto'] = $temp2[$row['ID_torneo']];
                unset($temp2[$temp['ID_torneo']]);
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

    if(isset($_POST['id-tourn'])) {
        $id_tourn = ($_POST['id-tourn']);

        $sql = "INSERT INTO Tourn_Subsc (ID_torneo,ID_Member) VALUES ('$id_tourn','$id')";
        if($db->query($sql) === true){

            $sqlB = "UPDATE Tournaments SET n_player=n_player+'1' WHERE ID_torneo='$id_tourn'";
            if($db->query($sqlB) === true){
                echo "tutte e due le query eseguite correttamente";
            }

        } else {
            echo "ERROR " . $db->errno;
        }
    }

}