<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/07/16
 * Time: 21:02
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "bf7588dfac7e65");
define("SAE_MYSQL_PASS",     "92137672");
define("SAE_MYSQL_DB",     "rdbeacoAvghw9hxk");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$conn);
$sql = "SELECT U.username, IF( ISNULL( B.locationname ) ,  '', B.locationname ) AS locationname, U.status2 FROM RDUSERINFO U ";
$sql = $sql."LEFT JOIN (SELECT M. *  FROM RDUSERSTATUS M WHERE M.updatetime = (  SELECT MAX( MM.updatetime )  FROM RDUSERSTATUS MM ";
$sql = $sql."WHERE M.useruuid = MM.useruuid ) GROUP BY M.useruuid) AS M ON U.uuid = M.useruuid LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
$sql = $sql."AND M.major = B.major AND M.minor = B.minor GROUP BY U.uuid ";


$result = mysql_query($sql, $conn);
while ($row=mysql_fetch_row($result)) {
    $arrayReturn=array('username'=>$row[0],'locationname'=>$row[1],'status'=>$row[2]);
    echo $arrayReturn;
    $d = array("locationname"=>$row[1],"username"=>$row[0],"status"=>$row[2]);
    echo "data:".json_encode($d)."\n\n";

    @ob_flush();
    flush();
    sleep(10);
}
mysql_close($conn);


/*
$d = array("locationname"=>"喫煙室","username"=>"123","status"=>"b");
echo "data:".json_encode($d)."\n\n";
//echo "locationname:"."";
//echo "status:"."";
@ob_flush();
flush();
sleep(10);*/

