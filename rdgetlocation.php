<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'librd.php';

//$arrReturn = getlocation();


$arrayReturn = array();

$result = query_sql("SELECT locationname,uuid,major,minor FROM RDBEACONINFO", $conn, $code, $errors);
if ($result) {
    while ($row = fetch_single_row($result)) {
        $arrayReturn[$row[0]] = array('uuid' => $row[1], 'major' => $row[2], 'minor' => $row[3]);
    }
} else {
    $arrayReturn['yyy'] = sqlsrv_errors();
}
return $arrayReturn;

sendResponse(json_encode($arrayReturn));

?>