<?php

//mysql_connect
define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "b5b35eecdcd068");
define("SAE_MYSQL_PASS",     "b5074189");
define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS) or die("connect failed" . mysql_error());

mysql_select_db(SAE_MYSQL_DB, $conn);

//params

$roomid = $_POST['roomid'];

$roomname = $_POST['roomname'];

$visible = $_POST['visible'];
//insert db

$sql = sprintf("INSERT INTO %s(id,roomid,roomname,visible) VALUES(null,'%s', '%s', '%s')", 'RDROOM',$roomid, $roomname,$visible);

$result=mysql_query($sql, $conn);

if ($result)

    echo mysql_insert_id($conn);

else

    echo 'f';

mysql_close($conn);

?>