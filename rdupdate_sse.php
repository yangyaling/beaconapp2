<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/07/16
 * Time: 21:02
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include 'lib.php';

$sql = "SELECT U.username, IF( ISNULL( B.locationname ) ,  '', B.locationname ) AS locationname, U.status2, U.comment FROM RDUSERINFO U ";
$sql = $sql."LEFT JOIN (SELECT M. *  FROM RDUSERSTATUS M WHERE M.updatetime = (  SELECT MAX( MM.updatetime )  FROM RDUSERSTATUS MM ";
$sql = $sql."WHERE M.useruuid = MM.useruuid ) GROUP BY M.useruuid) AS M ON U.uuid = M.useruuid LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
$sql = $sql."AND M.major = B.major AND M.minor = B.minor GROUP BY U.uuid ";


$result = query_sql($sql, $conn, $code, $errors);
while ($row=mysql_fetch_row($result)) {
    $d = array("locationname"=>$row[1],"username"=>$row[0],"status"=>$row[2],"comment"=>$row[3]);
    echo "data:".json_encode($d)."\n\n";

    @ob_flush();
    flush();
    sleep(1);
}
closeConnection($conn);


/*
$d = array("locationname"=>"喫煙室","username"=>"123","status"=>"b");
echo "data:".json_encode($d)."\n\n";
//echo "locationname:"."";
//echo "status:"."";
@ob_flush();
flush();
sleep(10);*/

