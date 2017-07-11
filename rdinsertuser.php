<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 13:57
 */
include 'lib.php';

$uuid = $_POST["uuid"];
$username = $_POST["username"];
$status2 = $_POST["status2"];
$ret = array();

$sqlcheck = "select * from RDUSERINFO WHERE uuid='" . $useruuid . "'";
$sqlupdate = "update RDUSERINFO set username='" . $username . "',status2='" . $status2 . "' WHERE uuid='" . $useruuid . "'";
$sqlinsert = "INSERT INTO RDUSERINFO (id, uuid, username,status2) VALUES (NULL,'" . $useruuid . "', '" . $username . "','" . $status2 . "')";

if ($result) {

    $sqlcheck = "select uuid,username,status2 from RDUSERINFO WHERE uuid='" . $useruuid . "'";
    $resultreq = query_sql($sqlcheck, $conn, $code, $errors);
    if ($resultreq) {

        while ($row = fetch_single_row($resultreq)) {
            //array_push($arrayReturn,$row);
            $ret['useruuid'] = $row[0];
            $ret['username'] = $row[1];
            $ret['status2'] = $row[2];

        }
    } else {
        $ret['error'] = sqlsrv_errors();
    }
}

sendResponse(json_encode($ret));
?>