<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'lib.php';

$uuid = $_GET["uuid"];
//$arrReturn = getmonitorinfo($uuid);

$arrayReturn = array();

$strquery = "SELECT  TOP 10
	U.username,
	B.locationname,
	M.updatetime,
	M.status
FROM
	RDMONITOR M
LEFT JOIN RDUSERINFO U ON M.useruuid = U.uuid
LEFT JOIN RDBEACONINFO B ON M.uuid = B.UUID
AND M.major = B.major
AND M.minor = B.minor
WHERE
	M.useruuid = '$uuid'
ORDER BY
	M.updatetime DESC";

$result = query_sql($strquery, $conn, $code, $errors);
$index = 0;
if ($result) {
    while ($row = fetch_single_row($result)) {
        $index = $index + 1;
        $arrayReturn[$row[0] . $row[2]] = array('location' => $row[1], 'updatetime' => $row[2], 'status' => $row[3]);
    }
}
$arrayReturn['cd']=$code;
$arrayReturn['er']=$errors;
sendResponse(json_encode($arrayReturn));

?>