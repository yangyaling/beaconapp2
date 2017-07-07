<?php

include 'lib.php';

$roomid = $_POST['roomid'];
$roomname = $_POST['roomname'];
$visible = $_POST['visible'];

$sql = sprintf("INSERT INTO %s(id,roomid,roomname,visible) VALUES(null,'%s', '%s', '%s')", 'RDROOM',$roomid, $roomname,$visible);
$result = query_sql($sql, $conn, $code, $errors);

closeConnection($conn);
if ($result)
    echo mysql_insert_id($conn);
else
    echo 'f';



?>