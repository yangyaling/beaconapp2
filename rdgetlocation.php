<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'lib.php';

//$arrReturn = getlocation();

$arrayReturn = array();
if ($conn) {
    $result = query_sql("SELECT locationname,uuid,major,minor FROM RDBEACONINFO");
    if ($result) {
        while ($row = mysql_fetch_row($result)) {
            $arrayReturn[$row[0]] = array('uuid' => $row[1], 'major' => $row[2], 'minor' => $row[3]);
        }
    } else {
    }
} else {
    //$arrayReturn['yyy'] = mysql_error();
}
//print_r($arrayReturn);
//return $arrayReturn;

sendResponse(json_encode($arrayReturn));

?>