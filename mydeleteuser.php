<?php

include 'lib.php';
//params

$id = $POST['id'];

//delete row in db
$errors = array();
$code = '200';
if ($conn) {
    $sql = sprintf("delete from %s where id=%d", 'RDUSERINFO', $id);
//    $result = query_sql($sql, $conn, $code, $errors);
    $result = mysql_query($sql, $conn);
    mysql_close($conn);
    if ($result)

        echo "t";

    else

        echo "f";
}
//closeConnection($conn);

?>