<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'librd.php';

$uuid = $_POST["uuid"];
$comment = $_POST["comment"];

sendResponse(json_encode( updateusercomment($uuid,$comment)));
?>