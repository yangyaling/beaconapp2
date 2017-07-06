<?php

//require_once 'smarty2_head.php';

include 'lib.php';

//params

$id = $_POST['id'];

$roomid = $_POST['roomid'];

$roomname = $_POST['roomname'];

$visible = $_POST['visible'];
//updata db

$sql = sprintf("update rdroom set roomid='%s',roomname='%s' ,visible='%d' where id=%d", $roomid, $roomname,$visible, $id);

$result=mysql_query($sql, $conn);

mysql_close($conn);

if ($result)

    echo 't';

else

    echo 'f';

?>