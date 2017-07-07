<?php

include 'lib.php';


$id = $_POST['id'];
$userid = $_POST['userid'];
$username = $_POST['username'];
$visible = $_POST['visible'];
$listindex = $_POST['listindex'];

$sql = sprintf("update rduserinfo set username='%s' ,visible='%d',listindex='%d' where id=%d",  $username,$visible,$listindex, $id);

$result = query_sql($sql, $conn, $code, $errors);

closeConnection($conn);

if ($result)

    echo 't';
else
    echo 'f';

?>