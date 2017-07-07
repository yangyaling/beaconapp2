<?php

include 'lib.php';
//params

$id = $GET['id'];

//delete row in db
$errors = array();
$code = '200';
if ($conn) {
    $sql = sprintf("delete from %s where id=%d", 'RDUSERINFO', $id);
    $result = query_sql($sql, $conn, $code, $errors);

    echo $code . "<br/>" . print_r($errors);

    if ($result)

        echo "t";

    else

        echo "f";
}
closeConnection($conn);

?>