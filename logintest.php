<?php

include 'lib.php';

//$lifeTime = 24 * 3600;
//session_set_cookie_params($lifeTime);
//
//session_start();

//  表单提交后...
$posts = $_POST;
//  清除一些空白符号
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}
$password = $posts["password"];
$username = $posts["username"];

$returnArray = array();
$returnArray['username'] = $username;
$returnArray['password'] = $password;

//查询用户是否存在
$sql = sprintf("SELECT * FROM [user] where userid='%s' and password='%s'", $username, $password);
$result = query_sql($sql, $conn, $code, $errors);
//
if ($myrow = fetch_single_row($result)) {
    $returnArray['result'] = $myrow;
} else {
    $returnArray['result'] = $myrow;
}

$returnArray['sql'] = $sql;
$returnArray['code'] = $code;
$returnArray['errors'] = $errors;

sendResponse(json_encode($returnArray));


?>