<?php

include 'librd.php';

//$lifeTime = 24 * 3600;
//session_set_cookie_params($lifeTime);
//
//session_start();

//  表单提交后...
//$posts = $_POST;
////  清除一些空白符号
//foreach ($posts as $key => $value) {
//    $posts[$key] = trim($value);
//}
//$password = $_POST["password"];
//$username = $_POST["username"];

$uuid = $_POST["uuid"];
$username = $_POST["username"];
$status2 = $_POST["status2"];


$result = array();
$result['uuid'] = $uuid;
$result['username'] = $username;
$result['status2'] = $status2;

//$result['username'] = $username;
//$result['password'] = $password;

////查询用户是否存在
//$sql = sprintf("SELECT * FROM [user] where userid='%s' and password='%s'",$username,$password);
//$result = query_sql($sql, $conn, $code, $errors);
//
//if ($myrow = fetch_single_row($result)){
////以下为身份验证成功后的相关操作
//    $_SESSION["admin"] = $username;
//    header("location:mybeacon.php");
//}else{
//    $_SESSION["admin"] = null;
//    header("Content-type: text/html; charset=utf-8");
//    echo "用户名或者密码不正确";
//    header("location:login.html");
//}


//sendResponse(json_encode( insertnewuser($uuid,$username,$status2)));

//sendResponse($result);
sendResponse(json_encode($result));


?>