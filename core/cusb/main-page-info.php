<?php
/**
 * Created by PhpStorm.
 * User: CarloAlberto
 * Date: 15/01/17
 * Time: 11:14
 */
require_once '../db_conn.php';
require_once '../functions.php';

/*
 * Check user permissions
 */
if(checkLogin()){

    /*
     * get info for main-cusb page
     */
    if($_SERVER['REQUEST_METHOD'] == "GET"){

        $id = $_SESSION['user_id'];
        $tot = array();

        //richiedo qual'è il prossimo torneo e allenamento ed evento disponibile
        $queries = array(

            "SELECT T.title, T.date, F.place 
                  from Field F, Tournaments T
                  INNER JOIN Tourn_Subsc S ON S.ID_torneo = T.ID_torneo
                  WHERE S.ID_Member = '$id'
                  AND T.ID_field = F.ID_field
                  AND date >'" . date("Y M D") ."'ORDER BY date ASC  LIMIT 1 ",

            "SELECT description, date, P.place 
                  from Field P, Events E
                  INNER JOIN follow_Ev F ON E.ID_EV = F.ID_EV
                  WHERE F.ID_Member = '$id' 
                  AND E.ID_field = P.ID_field
                  AND date >'" . date("Y M D") ."'ORDER BY date ASC  LIMIT 1 ",

            "SELECT of_what, date
                  from Trainings T
                  INNER JOIN follow_Tr F ON T.ID_training = F.ID_training
                  WHERE F.ID_Member = '$id' 
                  AND date >'" . date("Y M D") ."'ORDER BY date ASC  LIMIT 1 "
        );

        $queries_total = array(
            "SELECT count(S.ID_torneo)
                  from Tournaments T
                  INNER JOIN Tourn_Subsc S ON S.ID_torneo = T.ID_torneo
                  WHERE S.ID_Member = '$id'
                  AND date <'" . date("Y M D") ."'",

            "SELECT count(F.ID_EV)
                  from  Events E
                  INNER JOIN follow_Ev F ON E.ID_EV = F.ID_EV
                  WHERE F.ID_Member = '$id' 
                  AND date <'" . date("Y M D") ."'",

            "SELECT count(F.ID_training)
                  from Trainings T
                  INNER JOIN follow_Tr F ON T.ID_training = F.ID_training
                  WHERE F.ID_Member = '$id' 
                  AND date <'" . date("Y M D") ."'"
        );

        for($s = 0; $s < count($queries); $s++){
            $res = $db->query($queries[$s]);
            if($res->num_rows == 1 ){
                array_push($tot, $res->fetch_row());
            } else {
                echo $s."error" . $db->error;
            }
            //totals
            $res = $db->query($queries_total[$s]);
            if($res->num_rows == 1 ){
                array_push($tot, $res->fetch_row());
            } else {
                echo $s."error" . $db->error;
            }
        }
        echo json_encode($tot);
    }
}