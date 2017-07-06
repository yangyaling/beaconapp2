<?php

include 'lib.php';
//params

$id = $_POST['id'];

//delete row in db

$sql = sprintf("delete from %s where id=%d", 'RDUSERINFO', $id);

$result = mysql_query($sql, $conn);

mysql_close($conn);

if ($result)

    echo "t";

else

    echo "f";

?>