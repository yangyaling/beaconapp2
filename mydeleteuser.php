<?php

include 'lib.php';
//params

$id = $GET['id'];

//delete row in db


if ($conn) {
    $sql = sprintf("delete from %s where id=%d", 'RDUSERINFO', $id);
    $result = query_sql($sql, $conn);

    if ($result)

        echo "t";

    else

        echo "f";
}
closeConnection($conn);

?>