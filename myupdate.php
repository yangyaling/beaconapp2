<?php

//require_once 'smarty2_head.php';

include 'lib.php';

//params

$id = $_POST['id'];

$locationname = $_POST['locationname'];

$uuid = $_POST['uuid'];
$major = $_POST['major'];
$minor = $_POST['minor'];
$roomid = $_POST['roomid'];
//updata db

$sql = sprintf("update RDBEACONINFO set locationname='%s',uuid='%s',major='%s',minor='%s',roomid='%s' where id=%d", $locationname, $uuid,$major,$minor,$roomid, $id);

$result=mysql_query($sql, $conn);

mysql_close($conn);

if ($result)

    echo 't';

else

    echo 'f';

?>