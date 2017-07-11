<?php

include 'lib.php';

$roomid = $_POST['roomid'];
$roomname = $_POST['roomname'];
$visible = $_POST['visible'];

$sql = sprintf("INSERT INTO %s(roomid,roomname,visible) VALUES('%s', '%s', '%s')", 'RDROOM',$roomid, $roomname,$visible);
$result = query_sql($sql, $conn, $code, $errors);

closeConnection($conn);
if ($result)
    //echo mysql_insert_id($conn);
    echo "t";
else
    echo 'f';



?>