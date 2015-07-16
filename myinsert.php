<?php

//mysql_connect
define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "bf7588dfac7e65");
define("SAE_MYSQL_PASS",     "92137672");
define("SAE_MYSQL_DB",     "rdbeacoAvghw9hxk");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS) or die("connect failed" . mysql_error());

mysql_select_db(SAE_MYSQL_DB, $conn);

//params

$locationname = $_POST['locationname'];

$uuid = $_POST['uuid'];
$major = $_POST['major'];
$minor = $_POST['minor'];
//insert db

$sql = sprintf("INSERT INTO %s(id,locationname,uuid,major,minor) VALUES(null,'%s', '%s',%s,%s)", 'RDBEACONINFO',$locationname, $uuid,$major,$minor);

$result=mysql_query($sql, $conn);

if ($result)

    echo mysql_insert_id($conn);

else

    echo 'f';

mysql_close($conn);

?>