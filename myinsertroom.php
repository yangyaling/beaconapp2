<?php

include 'lib.php';

//params

$roomid = $_POST['roomid'];

$roomname = $_POST['roomname'];

$visible = $_POST['visible'];
//insert db

$sql = sprintf("INSERT INTO %s(id,roomid,roomname,visible) VALUES(null,'%s', '%s', '%s')", 'RDROOM',$roomid, $roomname,$visible);

$result=mysql_query($sql, $conn);
mysql_close($conn);
if ($result)

    echo mysql_insert_id($conn);

else

    echo 'f';



?>