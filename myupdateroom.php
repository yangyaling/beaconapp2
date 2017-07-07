<?php

//require_once 'smarty2_head.php';

include 'lib.php';


$id = $_POST['id'];
$roomid = $_POST['roomid'];
$roomname = $_POST['roomname'];
$visible = $_POST['visible'];

$sql = sprintf("update rdroom set roomid='%s',roomname='%s' ,visible='%d' where id=%d", $roomid, $roomname,$visible, $id);

$result = query_sql($sql, $conn, $code, $errors);

closeConnection($conn);

if ($result)

    echo 't';

else

    echo 'f';

?>