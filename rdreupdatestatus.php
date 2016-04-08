<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'librd.php';

$useruuid = $_GET["useruuid"];
$uuid = $_GET["uuid"];
$major = $_GET["major"];
$minor = $_GET["minor"];
$status = $_GET["status"];
$updatetime = $_GET["updatetime"];

$username = $_GET["username"];

sendResponse(json_encode( reupdatestatus($useruuid,$uuid,$major,$minor,$status,$updatetime)));
?>