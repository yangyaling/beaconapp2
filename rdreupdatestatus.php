<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'librd.php';

$useruuid = $_POST["useruuid"];
$uuid = $_POST["uuid"];
$major = $_POST["major"];
$minor = $_POST["minor"];
$status = $_POST["status"];
$updatetime = $_POST["updatetime"];

$username = $_POST["username"];

sendResponse(json_encode( reupdatestatus($useruuid,$uuid,$major,$minor,$status,$updatetime)));
?>