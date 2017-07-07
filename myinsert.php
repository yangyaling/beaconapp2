<?php

include 'lib.php';

$locationname = $_POST['locationname'];
$uuid = $_POST['uuid'];
$major = $_POST['major'];
$minor = $_POST['minor'];
$roomid = $_POST['roomid'];


$sql = sprintf("INSERT INTO rdbeaconinfo(id,locationname,uuid,major,minor,roomid) VALUES(null,'%s', '%s','%s','%s','%s')",$locationname, $uuid,$major,$minor,$roomid);
$result = query_sql($sql, $conn, $code, $errors);
closeConnection($conn);

if ($result)

    echo mysql_insert_id($conn);
else
    echo 'f';

?>