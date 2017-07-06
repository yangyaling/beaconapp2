<?php

include 'lib.php';

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