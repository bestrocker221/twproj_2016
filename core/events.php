<?php
/**
 * Created by PhpStorm.
 * User: CarloAlberto
 * Date: 29/12/16
 * Time: 12:00
 */

require 'db_conn.php';

//make request to the server, must retrieve json format and with

//$_SESSION['id'] = 2
$id = 2;

$sql = "SELECT id, title, url, start, end FROM `general_events` WHERE id_member='$id'";

$result = $db->query($sql);
$tot = array();

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['title'] = $row['title'];
        $temp['url'] = $row['url'];
        $temp['start'] = $row['start'];
        $temp['end'] = $row['end'];

        array_push($tot, $temp);
    }

    /*$num = $result->num_rows;
    for( $k=0;$k<$num;$k++){
        array_push($tot,$result->fetch_row());
    }*/
} else {
    echo "ERROR " . $db->errno;
    echo "num row" . $result->num_rows;
}
$tot = json_encode($tot);
echo $tot;

/*

            [
                {
                    title: \'All Day Event\',
                    start: \'2015-02-01\'
                },
                {
                    title: \'Long Event\',
                    start: \'2015-02-07\',
                    end: \'2015-02-10\'
                },
                {
                    id: 999,
                    title: \'Repeating Event\',
                    start: \'2015-02-09T16:00:00\'
                },
                {
                    id: 999,
                    title: \'Repeating Event\',
                    start: \'2015-02-16T16:00:00\'
                },
                {
                    title: \'Conference\',
                    start: \'2015-02-11\',
                    end: \'2015-02-13\'
                },
                {
                    title: \'Meeting\',
                    start: \'2015-02-12T10:30:00\',
                    end: \'2015-02-12T12:30:00\'
                },
                {
                    title: \'Lunch\',
                    start: \'2015-02-12T12:00:00\'
                },
                {
                    title: \'Meeting\',
                    start: \'2015-02-12T14:30:00\'
                },
                {
                    title: \'Happy Hour\',
                    start: \'2015-02-12T17:30:00\'
                },
                {
                    title: \'Dinner\',
                    start: \'2015-02-12T20:00:00\'
                },
                {
                    title: \'Birthday Party\',
                    start: \'2015-02-13T07:00:00\'
                },
                {
                    title: \'Click for Google\',
                    url: \'http://google.com/\',
                    start: \'2015-02-28\'
                },
                {
                    title: \'Click for SUCA\',
                    url: \'http://google.com/\',
                    start: \'2017-02-28\'
                }
            ]'
*/