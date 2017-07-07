<?php

include 'lib.php';


$id = $_POST['id'];

$sql = sprintf("delete from %s where id=%d", 'RDROOM', $id);

$result = query_sql($sql, $conn, $code, $errors);

closeConnection($conn);

if ($result)

    echo "t";

else

    echo "f";

?>