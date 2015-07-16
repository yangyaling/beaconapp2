<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'librd.php';

$uuid = $_POST["uuid"];
$username = $_POST["username"];
$status2 = $_POST["status2"];

sendResponse(json_encode( insertnewuser($uuid,$username,$status2)));
?>