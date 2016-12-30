<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 30/12/16
 * Time: 01:35
 */
require 'db_conn.php';

$sql = "SELECT * from news";

$tot = array();

$result = $db->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['text'] = $row['text'];
        $temp['date'] = $row['date'];

        array_push($tot, $temp);
    }
} else {
    echo "ERROR " . $db->errno;
    echo "num row" . $result->num_rows;
}
$tot = json_encode($tot);
echo $tot;