<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 30/12/16
 * Time: 12:51
 */
require_once '../db_conn.php';
require_once '../functions.php';

secure_session_start();

if(checkLogin()) {

    $id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        //$id = 6;

        $sqlA = "SELECT * FROM Events";
        $sqlB = "SELECT ID_EV from follow_Ev WHERE ID_Member='$id'";

        $tot = array();

        $temp2 = array();
        $result = $db->query($sqlB);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $temp2[$row['ID_EV']] = "yes";
            }
        }

        $result = $db->query($sqlA);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $temp = array();
                $temp['id_ev'] = $row['ID_EV'];
                $temp['description'] = $row['description'];
                $temp['date'] = $row['date'];
                $temp['description'] = $row['description'];
                $temp['n_partec'] = $row['n_partec'];
                if (array_key_exists($temp['id_ev'], $temp2)) {
                    $temp['iscritto'] = "yes";
                    unset($temp2[$$temp['id_ev']]);
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

    // $id = 6;

        if (isset($_POST['id-event'])) {
            $id_ev = ($_POST['id-event']);

            $sql = "INSERT INTO follow_Ev (ID_EV,ID_Member) VALUES ('$id_ev','$id')";
            if ($db->query($sql) === true) {

                $sqlB = "UPDATE Events SET n_partec=n_partec+'1' WHERE ID_EV='$id_ev'";
                if ($db->query($sqlB) === true) {
                    echo "tutte e due le query eseguite correttamente";
                }

            } else {
                echo "ERROR " . $db->errno;
            }
        }

    }
}