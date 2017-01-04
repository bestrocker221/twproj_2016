<?php
/**
 * Created by PhpStorm.
 * User: bsod
 * Date: 02/01/17
 * Time: 22:27
 */

require_once 'db_conn.php';
require_once 'functions.php';

secure_session_start();

if(checkLogin()){
    if($_SERVER['REQUEST_METHOD'] == "GET") {

        $temp = array();

        $temp['username'] = $_SESSION['email'];
        $temp['address'] = $_SESSION['address'];
        $temp['sex'] = $_SESSION['sex'];
        $temp['name'] = $_SESSION['name'];
        $temp['surname'] = $_SESSION['surname'];
        $temp['matr'] = $_SESSION['mat'];

        echo json_encode($temp);

        //var_dump($temp);
    }

} else {
    echo "not logged";
}