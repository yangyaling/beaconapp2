<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'lib.php';
$uuid = $_GET["uuid"];
$arrayReturn = array();

if ($conn) {
    $strquery = "SELECT U.username,B.locationname,M.updatetime,M.status FROM RDMONITOR M LEFT JOIN RDUSERINFO U ON M.useruuid = U.uuid LEFT JOIN RDBEACONINFO B ON M.uuid=B.UUID AND M.major=B.major AND M.minor = B.minor   WHERE M.useruuid ='" . $useruuid . "' ORDER BY M.updatetime desc LIMIT 10";
    $result = query_sql($strquery);
    $index = 0;
    while ($row = mysql_fetch_row($result)) {
        $index = $index + 1;
        $arrayReturn[$row[0] . $row[2]] = array('location' => $row[1], 'updatetime' => $row[2], 'status' => $row[3]);
    }
}

//$arrReturn = getmonitorinfo($uuid);
sendResponse(json_encode($arrayReturn));

?>