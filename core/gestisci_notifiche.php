<?php
/**
 * Created by PhpStorm.
 * User: CarloAlberto
 * Date: 19/12/16
 * Time: 19:00
 */
require_once 'db_conn.php';
require_once 'functions.php';

secure_session_start();

if(checkLogin()) {
//crea nuova notifica
    if (isset($_POST['id']) && isset($_POST['desc']) && isset($_POST['title'])) {
        $id = $_POST["id"];
        $desc = $_POST["desc"];
        $title = $_POST['title'];

        $sql = "INSERT INTO notifications (id_member,title,description) VALUES ('$id','$title','$desc')";
        if ($db->query($sql) === TRUE) {
            echo "OK";
        } else {
            echo "ERROR " . $db->error;
        }
    } //segna notifiche come già viste (gestisci metodo di richiesta)
    else if (isset($_POST['id'])) {

        //$id = $_SESSION['id'];

        $id = $_POST['id'];
        $sql = "UPDATE notifications SET showed='1' WHERE id_member='$id'";
        if ($db->query($sql) === TRUE) {
            echo "OK";
        } else {
            echo "ERROR " . $db->error;
        }
    } //aggiunge +1 alla visualizzazione della notifica (SISTEMA CON SESSION)
    else if (isset($_POST['id-notifica'])) {
        $id_notifica = $_POST['id-notifica'];
        $sql = "UPDATE notifications SET clicked=clicked + '1' WHERE id='$id_notifica'";
        if ($db->query($sql) === TRUE) {
            echo "OK";
        } else {
            echo "ERROR " . $db->error;
        }
    } //riceve notifiche --> aggiusta per richieste notifiche (add total)
    else if (isset($_GET["id"])) {
        $id = $_GET['id'];

        $sql = "SELECT title,description, date, showed, clicked,id FROM notifications WHERE id_member='$id' ORDER BY date DESC";
        $sql2 = "SELECT COUNT(*) FROM notifications WHERE id_member='$id' and showed='0'";

        $tot = array();
        if (!$db) {
            echo "NO DB";
        }
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $num = $result->num_rows;
            for ($k = 0; $k < $num; $k++) {
                array_push($tot, $result->fetch_row());
            }
        } else {
            echo "ERROR1 " . $db->errno;
            echo "num row" . $result->num_rows;
        }

        $result = $db->query($sql2);
        if ($result->num_rows == 1) {
            $tot['total'] = $result->fetch_row()[0];
        } else {
            echo "ERROR2 " . $db->error;
        }

        $tot = json_encode($tot);
        echo $tot;
    }
}