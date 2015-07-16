<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'librd.php';
$uuid = $_GET["uuid"];
$arrReturn = getmonitorinfo($uuid);
sendResponse(json_encode($arrReturn));

?>