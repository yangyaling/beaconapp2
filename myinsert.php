<?php

//mysql_connect
define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "b5b35eecdcd068");
define("SAE_MYSQL_PASS",     "b5074189");
define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS) or die("connect failed" . mysql_error());

mysql_select_db(SAE_MYSQL_DB, $conn);

//params

$locationname = $_POST['locationname'];

$uuid = $_POST['uuid'];
$major = $_POST['major'];
$minor = $_POST['minor'];
$roomid = $_POST['roomid'];
//insert db

$sql = sprintf("INSERT INTO rdbeaconinfo(id,locationname,uuid,major,minor,roomid) VALUES(null,'%s', '%s','%s','%s')",$locationname, $uuid,$major,$minor,$roomid);

$result=mysql_query($sql, $conn);
mysql_close($conn);
if ($result)

    echo 't';

else

    echo $sql;



?>