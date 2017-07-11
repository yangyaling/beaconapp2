<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'lib.php';

date_default_timezone_set('Asia/Tokyo');

//获取post过来的数据
$json_string = file_get_contents('php://input');
if(ini_get("magic_quotes_gpc")=="1")
{
    $json_string=stripslashes($json_string);
}
$obj = json_decode($json_string,true);
$updatedata = $obj['updatedata'];

$ret=array();

foreach ($updatedata as $key => $node) {
    $useruuid = $node["useruuid"];
    $uuid = $node["uuid"];
    $major = $node["major"];
    $minor = $node["minor"];
    $status = $node["status"];
    $updatetime = $node["updatetime"];
    //$result = reupdatestatus($useruuid,$uuid,$major,$minor,$status,$updatetime);

    $sqlinsert = "INSERT INTO RDMONITOR (useruuid, uuid,major,minor,updatetime, status) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "','" . $updatetime . "','" . $status . "')";
    $ret['sql'] = $sqlinsert;
    $result = query_sql($sqlinsert, $conn, $code, $errors);

    $sqlstsins = "INSERT INTO RDUSERSTATUS (useruuid, uuid, major,minor,updatetime) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "', '" . $updatetime . "')";
    $sqlstsdel = "DELETE FROM RDUSERSTATUS WHERE useruuid='" . $useruuid . "' AND uuid='" . $uuid . "' AND major='" . $major . "' AND minor='" . $minor . "'";
    if ($status == '1') {
        $result = query_sql($sqlstsins, $conn, $code, $errors);
    } else {
        $result = query_sql($sqlstsdel, $conn, $code, $errors);
    }
}

sendResponse(json_encode( $ret));
?>