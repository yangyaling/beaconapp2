<?php

//require_once 'smarty2_head.php';

//mysql_connect
define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "b5b35eecdcd068");
define("SAE_MYSQL_PASS",     "b5074189");
define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS) or die("connect failed" . mysql_error());

mysql_select_db(SAE_MYSQL_DB, $conn);

//params

$id = $_POST['id'];

$userid = $_POST['userid'];

$username = $_POST['username'];

$visible = $_POST['visible'];

$listindex = $_POST['listindex'];
//updata db

$sql = sprintf("update rduserinfo set username='%s' ,visible='%d',listindex='%d' where id=%d",  $username,$visible,$listindex, $id);

$result=mysql_query($sql, $conn);

mysql_close($conn);

if ($result)

    echo 't';

else

    echo 'f';

?>