<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'librd.php';

//header('Content-type:text/json;charset=utf-8');
date_default_timezone_set('Asia/Tokyo');

//获取post过来的数据
$json_string = file_get_contents('php://input'); ##今回のキモ
if(ini_get("magic_quotes_gpc")=="1")
{
    $json_string=stripslashes($json_string);
}
$obj = json_decode($json_string,true);
$ret=array();
$updatedata = $obj['updatedata'];

foreach ($updatedata as $key => $node) {
    $useruuid = $node["useruuid"];
    $uuid = $node["uuid"];
    $major = $node["major"];
    $minor = $node["minor"];
    $status = $node["status"];
    $updatetime = $node["updatetime"];
    $result = reupdatestatus($useruuid,$uuid,$major,$minor,$status,$updatetime);
}

sendResponse(json_encode( $ret));
?>